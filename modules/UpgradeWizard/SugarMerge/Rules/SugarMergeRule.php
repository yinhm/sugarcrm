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

class SugarMergeRule
{
    
    /**
     * runRules
     * 
     * This is a static method that checks to see if there are any special rules to run 
     * for a given module when merging metadata files for upgrades.
     * 
     * @param $module String value of the module
     * @param $original_file String value of path to the original metadata file
     * @param $new_file String value of path to the new metadata file (the target instance's default metadata file)
     * @param $custom_file String value of path to the custom metadata file
     * @param $save boolean value indicating whether or not to save changes
     * @return boolean true if a rule was found and run, false otherwise
     */
    public static function runRules($module, $original_file, $new_file, $custom_file=false, $save=true)
    {
    	$check_objects = array('Person');
    	foreach($check_objects as $name) {
    		if(SugarModule::get($module)->moduleImplements($name)) {
    		   $rule_file = 'modules/UpgradeWizard/SugarMerge/Rules/' . $name . 'MergeRule.php';
    		   if(file_exists($rule_file)) {
    		   	  require_once($rule_file);
    		   	  $class_name = $name . 'MergeRule';
    		   	  $instance = new $class_name();
    		   	  return $instance->merge($module, $original_file, $new_file, $custom_file=false, $save=true);
    		   }
    		} 
    	}
    	return false;
    }   

}
?>