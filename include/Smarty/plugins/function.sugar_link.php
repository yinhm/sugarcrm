<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2010 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


function smarty_function_sugar_link($params, &$smarty)
{
	if(empty($params['module'])){
		$smarty->trigger_error("sugar_link: missing 'module' parameter");
		return;
	}
	if(!empty($params['data']) && is_array($params['data'])){
		$link_url = 'index.php?';
		$link_url .= 'module=iFrames&action=index';
		$link_url .= '&record='.$params['data']['0'];
		$link_url .= '&tab=true';
    }else{
		$action = (!empty($params['action']))?$params['action']:'index';
	    
	    $link_url = 'index.php?';
	    $link_url .= 'module='.$params['module'].'&action='.$action;
	
	    if (!empty($params['record'])) { $link_url .= "&record=".$params['record']; }
	    if (!empty($params['extraparams'])) { $link_url .= '&'.$params['extraparams']; }
	}
	
	if (isset($params['link_only']) && $params['link_only'] == 1 ) {
        // Let them just get the url, they want to put it someplace
        return $link_url;
    }
	
	$id = (!empty($params['id']))?' id="'.$params['id'].'"':'';
	$class = (!empty($params['class']))?' class="'.$params['class'].'"':'';
	$style = (!empty($params['style']))?' style="'.$params['style'].'"':'';
	$title = (!empty($params['title']))?' title="'.$params['title'].'"':'';
	$accesskey = (!empty($params['accesskey']))?' accesskey="'.$params['accesskey'].'" ':'';
    $options = (!empty($params['options']))?' '.$params['options'].'':'';
    if(!empty($params['data']) && is_array($params['data']))
		$label =$params['data']['4'];
	elseif ( !empty($params['label']) )
	    $label = $params['label'];
	else
	    $label = (!empty($GLOBALS['app_list_strings']['moduleList'][$params['module']]))?$GLOBALS['app_list_strings']['moduleList'][$params['module']]:$params['module'];

    $link = '<a href="'.$link_url.'"'.$id.$class.$style.$options.'>'.$label.'</a>';
    return $link;
}