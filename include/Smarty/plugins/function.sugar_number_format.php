<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_currency_format} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_currency_format<br>
 * Purpose:  formats a number
 * 
 * @author Wayne Pan {wayne at sugarcrm.com}
 * @param array
 * @param Smarty
 */
function smarty_function_sugar_number_format($params, &$smarty) {
    global $locale;

	if(!isset($params['var']) || $params['var'] == '') {  
        return '';
    } 

    if ( !isset($params['precision']) ) {
        $params['precision'] = $locale->getPrecedentPreference('default_currency_significant_digits');
    }

    $_contents = format_number($params['var'], $params['precision'], $params['precision'], $params);

    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $_contents);
    } else {
        return $_contents;
    }
}

?>
