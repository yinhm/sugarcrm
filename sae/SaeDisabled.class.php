<?php
/* 
 * Mockup disabled function in Sina App Engine
 * 
 * @author: yinhm <yinhm@twitter>
 */

class SaeDisabled {

	private static $iniVars = array(
		'safe_mode' => null,
		'sendmail_from' => 'me@example.com',
		'magic_quotes_gpc' => null,
		'include_path' => '.',
		'open_basedir' => null,
		'pcre.backtrack_limit' => 100000,
		'mssql.charset' => null,
		'upload_tmp_dir' => null,
		'zend.ze1_compatibility_mode' => null,
		'allow_call_time_pass_reference' => null,
		'memory_limit' => '128M',
		'upload_max_filesize' => '20M',
		'post_max_size' => '8M',
		'max_execution_time' => 0,
		'zlib.output_compression' => null,
		'fastcgi.logging' => null,
		'variables_order' => 'GPCS'
	);

	public static function get_magic_quotes_gpc() {
		return 0;
	}

	public static function php_uname($mode = "a") {
		if ($mode == 's') {
			return 'Linux';
		}
		if ($mode == 'r') {
			return '1.0.2';
		}
		return 'Linux Sina App Engine';
	}

	public static function set_time_limit($limit) {
		// no effect
	}

	public static function ini_set($varname, $newvalue) {
		// no effect
	}

	public static function ini_get($varname) {
		$ret = null;
		if(isset(self::$iniVars[$varname])) {
			$ret = self::$iniVars[$varname];
		}
		return $ret;
	}

	public static function get_cfg_var($name) {
		return 'SAE disabled';
	}

}

class SinaAppEnginePatch {

	public static function cache_dir($pathname) {
		return preg_match('/(cache\/|custom\/)/', $pathname);
	}

	public static function make_cache_protocol($pathname) {
		if (substr($pathname, 0, 8) != 'saemc://') {
			$pathname = 'saemc://' . $pathname;
		}
		return $pathname;
	}
	
}


if (!function_exists('memcache_init')) {
	function memcache_init() {
		return memcache_connect("localhost");
	}
}

function memcache_client() {
	static $conn;
	if ($conn) {
		return $conn;
	}

	$conn = memcache_init();

	return $conn;
}


function memcache_cache_handler($action, &$smarty_obj, &$cache_content, $tpl_file=null, $cache_id=null, $compile_id=null, $exp_time=null) {
	// ref to the memcache object
	$m = memcache_client();

	// the key to store cache_ids under, used for clearing
	$key = 'smarty_caches';

	// check memcache object
	if (get_class($m) != 'Memcache') {
		$smarty_obj->trigger_error('cache_handler: \$m is not a memcached object');
		return false;
	}

	// unique cache id
	$cache_id = md5($tpl_file.$cache_id.$compile_id);

	switch ($action) {
		case 'read':
		// grab the key from memcached
			$contents = $m->get($cache_id);

			// use compression
			if($smarty_obj->use_gzip && function_exists("gzuncompress")) {
				$cache_content = gzuncompress($contents);
			} else {
				$cache_content = $contents;
			}

			$return = true;
			break;

		case 'write':
		// use compression
			if($smarty_obj->use_gzip && function_exists("gzcompress")) {
				$contents = gzcompress($cache_content);
			} else {
				$contents = $cache_content;
			}

			// add the cache_id to the $key string
			$caches = $m->get($key);
			if (!is_array($caches)) {
				$caches = array($cache_id);
				$m->set($key, $caches);
			} else if (!in_array($cache_id, $caches)) {
					array_push($caches, $cache_id);
					$m->set($key, $caches);
				}

			// store the value in memcached
			$stored = $m->set($cache_id, $contents);

			if(!$stored) {
				$smarty_obj->trigger_error("cache_handler: set failed.");
			}

			$return = true;
			break;

		case 'clear':
			if(empty($cache_id) && empty($compile_id) && empty($tpl_file)) {
			// get all cache ids
				$caches = $m->get($key);

				if (is_array($caches)) {
					$len = count($caches);
					for ($i=0; $i<$len; $i++) {
					// assume no errors
						$m->delete($caches[$i]);
					}

					// delete the cache ids
					$m->delete($key);

					$result = true;
				}
			} else {
				$result = $m->delete($cache_id);
			}
			if(!$result) {
				$smarty_obj->trigger_error("cache_handler: query failed.");
			}
			$return = true;
			break;

		default:
		// error, unknown action
			$smarty_obj->trigger_error("cache_handler: unknown action \"$action\"");
			$return = false;
			break;
	}

	return $return;
}
