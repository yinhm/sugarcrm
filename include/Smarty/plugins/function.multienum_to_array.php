<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty modifier to convert multienum separated value to Array
 *
 * Type:     function<br>
 * Name:     multienum_to_array<br>
 * Purpose:  Utility to transform multienum String to Array format
 * @author   Collin Lee <clee at sugarcrm dot com>
 * @param string The multienum field's value(s) as a String
 * @param default The multienum field's default value
 * @return Array
 */
function smarty_function_multienum_to_array($params, &$smarty)
{
	$ret = "";
	if(empty($params['string'])) {
        if (empty($params['default']))
            $ret = array();
        else if(is_array($params['default']))
            $ret = $params['default'];
        else
           $ret = unencodeMultienum($params['default']);
    } else {
    	if (is_array($params['string']))
    	  $ret = $params['string'];
    	else
    	  $ret = unencodeMultienum($params['string']);
    }
	
    
	if (!empty($params['assign']))
	{
		$smarty->assign($params['assign'], $ret);
		return "";
	}
	
	return ($ret);
}

?>
