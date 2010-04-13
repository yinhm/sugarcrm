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
<script type="text/javascript" src="include/javascript/sugar_grp_yui_widgets.js"></script>
<link rel="stylesheet" type="text/css" href="{sugar_getjspath file='modules/Connectors/tpls/tabs.css'}"/>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan='100'><h2>{$title}</h2></td></tr>
<tr><td colspan='100'>
{$description}
</td></tr><tr><td><br></td></tr><tr><td colspan='100'>

<form name="ConfigureSubPanels" method="POST">
	<input type="hidden" name="module" value="Administration">
	<input type="hidden" name="action" value="ConfigureSubPanels">
	<input type="hidden" name="disabled_panels" value="">
	<input type="hidden" name="enabled_panels" value="">
	<input type="hidden" name="Save_or_Cancel" value="save">	

	<table border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td>
			<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" onclick="SUGAR.saveSubpanelSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
			<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.ConfigureSubPanels.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
	
	<div class='add_table' style='margin-bottom:5px'>
		<table id="ConfigureSubPanels" class="themeSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width='1%'>
					<div id="enabled_div"></div>	
				</td>
				<td>
					<div id="disabled_div"></div>
				</td>
			</tr>
		</table>
	</div>
	
	<table border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td>
				<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button primary" onclick="SUGAR.saveSubpanelSettings();" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">
				<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="button" onclick="document.ConfigureSubPanels.action.value='';" type="submit" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
			</td>
		</tr>
	</table>
</form>



<script type="text/javascript">
(function(){ldelim}
    var Connect = YAHOO.util.Connect;
	Connect.url = 'index.php';
    Connect.method = 'POST';
    Connect.timeout = 300000; 

	var enabled_modules = {$enabled_panels};
	var disabled_modules = {$disabled_panels};
	var lblEnabled = '{sugar_translate label="LBL_VISIBLE_PANELS"}';
	var lblDisabled = '{sugar_translate label="LBL_HIDDEN_PANELS"}';
	{literal}
	SUGAR.subEnabledTable = new YAHOO.SUGAR.DragDropTable(
		"enabled_div",
		[{key:"label",  label: lblEnabled, width: 200, sortable: false},
		 {key:"module", label: lblEnabled, hidden:true}],
		new YAHOO.util.LocalDataSource(enabled_modules, {
			responseSchema: {
			   fields : [{key : "module"}, {key : "label"}]
			}
		}),  
		{height: "300px"}
	);
	SUGAR.subDisabledTable = new YAHOO.SUGAR.DragDropTable(
		"disabled_div",
		[{key:"label",  label: lblDisabled, width: 200, sortable: false},
		 {key:"module", label: lblDisabled, hidden:true}],
		new YAHOO.util.LocalDataSource(disabled_modules, {
			responseSchema: {
			   fields : [{key : "module"}, {key : "label"}]
			}
		}),
		{height: "300px"}
	);
	SUGAR.subEnabledTable.disableEmptyRows = true;
	SUGAR.subDisabledTable.disableEmptyRows = true;
	SUGAR.subEnabledTable.addRow({module: "", label: ""});
	SUGAR.subDisabledTable.addRow({module: "", label: ""});
	SUGAR.subEnabledTable.render();
	SUGAR.subDisabledTable.render();
	
	SUGAR.saveSubpanelSettings = function()
	{
		var disabledTable = SUGAR.subDisabledTable;
		var panels = "";
		for(var i=0; i < disabledTable.getRecordSet().getLength(); i++){
			var data = disabledTable.getRecord(i).getData();
			if (data.module && data.module != '')
			    panels += "," + data.module;
		}
		panels = panels == "" ? panels : panels.substr(1);
		
		
		ajaxStatus.showStatus(SUGAR.language.get('Administration', 'LBL_SAVING'));
        Connect.asyncRequest(
            Connect.method, 
            Connect.url, 
            {success: SUGAR.saveCallBack},
			SUGAR.util.paramsToUrl({
				module: "Administration",
				action: "ConfigureSubPanels",
				Save_or_Cancel:'save',
				disabled_panels: panels
			}) + "to_pdf=1"
        );
		
		return true;
	}
	SUGAR.saveCallBack = function(o)
	{
	   ajaxStatus.flashStatus(SUGAR.language.get('app_strings', 'LBL_DONE'));
	   if (o.responseText == "true")
	   {
	       window.location.assign('index.php?module=Administration&action=ConfigureSubPanels');
	   } 
	   else 
	   {
	       YAHOO.SUGAR.MessageBox.show({msg:o.responseText});
	   }
	}	
})();
{/literal}
</script>