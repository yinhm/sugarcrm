<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_field} function plugin
 *
 * Type:     function
 * Name:     sugar_run_helper
 * Purpose:  Runs helper functions as defined in the vardef for specific fields
 * 
 * @author Rob Aagaard {rob at sugarcrm.com}
 * @param array
 * @param Smarty
 */

function smarty_function_sugar_run_helper($params, &$smarty)
{
    $error = false;

    if(!isset($params['func'])) {
        $error = true;
        $smarty->trigger_error("sugar_field: missing 'func' parameter");
    }
    if(!isset($params['displayType'])) {
        $error = true;
        $smarty->trigger_error("sugar_field: missing 'displayType' parameter");
    }
    if(!isset($params['bean'])) {
        $params['bean'] = $GLOBALS['focus'];
    }

    if ( $error ) {
        return;
    }

    $funcName = $params['func'];

    if ( !empty($params['include']) ) {
        require_once($params['include']);
    }

    $_contents = $funcName($params['bean'],$params['field'],$params['value'],$params['displayType']);
    return $_contents;
}
?>
