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

$default_connectors = array (
  'ext_rest_linkedin' => 
  array (
    'id' => 'ext_rest_linkedin',
    'name' => 'LinkedIn&#169;',
    'enabled' => true,
    'directory' => 'modules/Connectors/connectors/sources/ext/rest/linkedin',
    'modules' => 
    array ( 
    ),
  ), 
);


$default_modules_sources = array (
  'Accounts' => 
  array (
    'ext_rest_linkedin' => 'ext_rest_linkedin',
  ),
  'Contacts' => 
  array (
    'ext_rest_linkedin' => 'ext_rest_linkedin',
  ),
  'Leads' =>
  array (
    'ext_rest_linkedin' => 'ext_rest_linkedin',
  ),
  'Prospects' =>
  array (
    'ext_rest_linkedin' => 'ext_rest_linkedin',
  ),
);

if(!file_exists('custom/modules/Connectors/metadata')) {
   mkdir_recursive('custom/modules/Connectors/metadata');
}

if(!write_array_to_file('connectors', $default_connectors, 'custom/modules/Connectors/metadata/connectors.php')) {
   $GLOBALS['log']->fatal('Cannot write file custom/modules/Connectors/metadata/connectors.php');
}	

if(!write_array_to_file('modules_sources', $default_modules_sources, 'custom/modules/Connectors/metadata/display_config.php')) {
   $GLOBALS['log']->fatal('Cannot write file custom/modules/Connectors/metadata/display_config.php');
}

require_once('include/connectors/utils/ConnectorUtils.php');
if(!ConnectorUtils::updateMetaDataFiles()) {
   $GLOBALS['log']->fatal('Cannot update metadata files for connectors');	
}

?>