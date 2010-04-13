/*  Copyright Mihai Bazon, 2002, 2003  |  http://dynarch.com/mishoo/
 * ---------------------------------------------------------------------------
 *
 * The DHTML Calendar
 *
 * Details and latest version at:
 * http://dynarch.com/mishoo/calendar.epl
 *
 * This script is distributed under the GNU Lesser General Public License.
 * Read the entire license text here: http://www.gnu.org/licenses/lgpl.html
 *
 * This file defines helper functions for setting up the calendar.  They are
 * intended to help non-programmers get a working calendar on their site
 * quickly.  This script should not be seen as part of the calendar.  It just
 * shows you what one can do with the calendar, while in the same time
 * providing a quick and simple method for setting it up.  If you need
 * exhaustive customization of the calendar creation process feel free to
 * modify this code to suit your needs (this is recommended and much better
 * than modifying calendar.js itself).
 */
Calendar.setup=function(params){function param_default(pname,def){if(typeof params[pname]=="undefined"){params[pname]=def;}};param_default("inputFieldObj",null);param_default("displayAreaObj",null);param_default("buttonObj",null);param_default("inputField",null);param_default("displayArea",null);param_default("button",null);param_default("eventName","click");param_default("ifFormat","%Y/%m/%d");param_default("daFormat","%Y/%m/%d");param_default("singleClick",true);param_default("disableFunc",null);param_default("dateStatusFunc",params["disableFunc"]);param_default("firstDay",isNaN(Calendar._FD)?0:Calendar._FD);param_default("align","Br");param_default("range",[1900,2999]);param_default("weekNumbers",true);param_default("flat",null);param_default("flatCallback",null);param_default("onSelect",null);param_default("onClose",null);param_default("onOpen",null);param_default("onUpdate",null);param_default("date",null);param_default("showsTime",false);param_default("timeFormat","24");param_default("electric",true);param_default("step",2);param_default("position",null);param_default("cache",false);param_default("showOthers",false);var tmp=["inputField","displayArea","button"];for(var i in tmp)
{if(params[tmp[i]+'Obj']==null&&typeof params[tmp[i]]=="string")
{params[tmp[i]]=document.getElementById(params[tmp[i]]);}
else
{params[tmp[i]]=params[tmp[i]+'Obj'];}}
if(!(params.flat||params.inputField||params.displayArea||params.button)){return false;}
function onSelect(cal){var p=cal.params;var update=(cal.dateClicked||p.electric);if(update&&p.flat){if(typeof p.flatCallback=="function")
p.flatCallback(cal);else
alert("No flatCallback given -- doing nothing.");return false;}
if(update&&p.inputField){val=cal.date.print(p.daFormat);val=val.substring(0,10);p.inputField.value=val;if(typeof p.inputField.onchange=="function")
p.inputField.onchange();}
if(update&&p.displayArea)
p.displayArea.innerHTML=cal.date.print(p.daFormat);if(update&&p.singleClick&&cal.dateClicked)
cal.callCloseHandler();if(update&&typeof p.onUpdate=="function")
p.onUpdate(cal);};if(params.flat!=null){if(typeof params.flat=="string")
params.flat=document.getElementById(params.flat);if(!params.flat){alert("Calendar.setup:\n  Flat specified but can't find parent.");return false;}
var cal=new Calendar(params.firstDay,params.date,params.onSelect||onSelect);cal.showsTime=params.showsTime;cal.time24=(params.timeFormat=="24");cal.params=params;cal.weekNumbers=params.weekNumbers;cal.setRange(params.range[0],params.range[1]);cal.setDateStatusHandler(params.dateStatusFunc);cal.create(params.flat);cal.show();return false;}
var triggerEl=params.button||params.displayArea||params.inputField;triggerEl["on"+params.eventName]=function(){if(params.onOpen){params.onOpen();}
var dateEl=params.inputField||params.displayArea;var dateFmt=((typeof params.ifFormat!="undefined")&&params.ifFormat!="%Y/%m/%d")?params.ifFormat:params.daFormat;params.daFormat=dateFmt;if(dateFmt.indexOf(" ")>-1){dateFmt=dateFmt.substring(0,dateFmt.indexOf(" "));}
var mustCreate=false;var cal=window.calendar;if(!(cal&&params.cache)){window.calendar=cal=new Calendar(params.firstDay,params.date,params.onSelect||onSelect,params.onClose||function(cal){cal.hide();},params.inputField);cal.showsTime=params.showsTime;cal.time24=(params.timeFormat=="24");cal.weekNumbers=params.weekNumbers;mustCreate=true;}else{if(params.date)
cal.setDate(params.date);cal.hide();}
cal.showsOtherMonths=params.showOthers;cal.yearStep=params.step;cal.setRange(params.range[0],params.range[1]);cal.params=params;cal.setDateStatusHandler(params.dateStatusFunc);cal.setDateFormat(dateFmt);if(mustCreate)
cal.create();cal.parseDate(dateEl.value||dateEl.innerHTML);cal.refresh();if(!params.position)
cal.showAtElement(params.button||params.displayArea||params.inputField,params.align);else
cal.showAt(params.position[0],params.position[1]);return false;};};