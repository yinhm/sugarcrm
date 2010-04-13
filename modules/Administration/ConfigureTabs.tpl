{*
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
*}
<link rel="stylesheet" type="text/css" href="{sugar_getjspath file='modules/Connectors/tpls/tabs.css'}"/>
<script type="text/javascript" src="include/javascript/sugar_grp_yui_widgets.js"></script>
<style>.yui-dt-scrollable .yui-dt-bd {ldelim}overflow-x: hidden;{rdelim}</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan='100'><h2>{$title}</h2></td></tr>
<tr><td colspan='100'>
{$description}
</td></tr><tr><td><br></td></tr><tr><td colspan='100'>

<form name="ConfigureTabs" method="POST"  method="POST" action="index.php">
	<input type="hidden" name="module" value="Administration">
	<input type="hidden" name="action" value="SaveTabs">
	<input type="hidden" id="enabled_tabs" name="enabled_tabs" value="">
	<input type="hidden" name="disabled_tabs" value="">
	<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
	<input type="hidden" name="return_action" value="{$RETURN_ACTION}">

	<table border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td>
				<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="SUGAR.saveConfigureTabs();this.form.action.value='SaveTabs'; " type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" > 
				<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value='{$RETURN_ACTION}'; this.form.module.value='{$RETURN_MODULE}';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
	<input type='checkbox' name='user_edit_tabs' value=1 class='checkbox' {if !empty($user_can_edit)}CHECKED{/if}>&nbsp;<b onclick='document.EditView.user_edit_tabs.checked= !document.EditView.user_edit_tabs.checked' style='cursor:default'>{$MOD.LBL_ALLOW_USER_TABS}</b>
	<div class='add_table' style='margin-bottom:5px'>
		<table id="ConfigureTabs" class="themeSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width='1%'>
					<div id="enabled_div" class="enabled_tab_workarea">
					</div>
				</td>
				<td>
					<div id="disabled_div" class="disabled_tab_workarea">
					</div>
				</td>
			</tr>
		</table>
	</div>
	
	<table border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td>
				<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button primary" onclick="SUGAR.saveConfigureTabs();this.form.action.value='SaveTabs'; " type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" > 
				<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="this.form.action.value='{$RETURN_ACTION}'; this.form.module.value='{$RETURN_MODULE}';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
</form>


<script type="text/javascript">
(function(){ldelim}
	var enabled_modules = {$enabled_tabs};
	var disabled_modules = {$disabled_tabs};
	var lblEnabled = '{sugar_translate label="LBL_VISIBLE_TABS"}';
	var lblDisabled = '{sugar_translate label="LBL_HIDDEN_TABS"}';
	{literal}
	SUGAR.enabledTabsTable = new YAHOO.SUGAR.DragDropTable(
		"enabled_div",
		[{key:"label",  label: lblEnabled, width: 200, sortable: false},
		 {key:"module", label: lblEnabled, hidden:true}],
		new YAHOO.util.LocalDataSource(enabled_modules, {
			responseSchema: {
			   resultsList : "modules",
			   fields : [{key : "module"}, {key : "label"}]
			}
		}), 
		{height: "300px"}
	);
	SUGAR.disabledTabsTable = new YAHOO.SUGAR.DragDropTable(
		"disabled_div",
		[{key:"label",  label: lblDisabled, width: 200, sortable: false},
		 {key:"module", label: lblDisabled, hidden:true}],
		new YAHOO.util.LocalDataSource(disabled_modules, {
			responseSchema: {
			   resultsList : "modules",
			   fields : [{key : "module"}, {key : "label"}]
			}
		}),
		{height: "300px"}
	);
	SUGAR.enabledTabsTable.disableEmptyRows = true;
    SUGAR.disabledTabsTable.disableEmptyRows = true;
    SUGAR.enabledTabsTable.addRow({module: "", label: ""});
    SUGAR.disabledTabsTable.addRow({module: "", label: ""});
	SUGAR.enabledTabsTable.render();
	SUGAR.disabledTabsTable.render();
	
	SUGAR.saveConfigureTabs = function()
	{
		var enabledTable = SUGAR.enabledTabsTable;
		var modules = [];
		for(var i=0; i < enabledTable.getRecordSet().getLength(); i++){
			var data = enabledTable.getRecord(i).getData();
			if (data.module && data.module != '')
			    modules[i] = data.module;
		}
		YAHOO.util.Dom.get('enabled_tabs').value = YAHOO.lang.JSON.stringify(modules);
	}
})();
{/literal}
</script>