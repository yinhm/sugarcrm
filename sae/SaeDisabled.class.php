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

}


if (!function_exists('memcache_init')) {
	function memcache_init() {
		return memcache_connect("localhost");
	}
}