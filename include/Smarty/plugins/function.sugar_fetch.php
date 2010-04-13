<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_fetch} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_fetch<br>
 * Purpose:  grabs the requested index from either an object or an array
 * 
 * @author Rob Aagaard {rob at sugarcrm.com}
 * @param array
 * @param Smarty
 */

function smarty_function_sugar_fetch($params, &$smarty)
{
	if(empty($params['key']))  {
	    $smarty->trigger_error("sugar_fetch: missing 'key' parameter");
	    return;
	}    
    if(empty($params['object'])) {
	    $smarty->trigger_error("sugar_fetch: missing 'object' parameter");
	    return;        
    }
    
    $theKey = $params['key'];
    if(is_object($params['object'])) {
        $theData = $params['object']->$theKey;
    } else {
        $theData = $params['object'][$theKey];
    }

    if(!empty($params['assign'])) {
        $smarty->assign($params['assign'],$theData);
    } else {
        return $theData;
    }
}
