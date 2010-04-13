/*
 Copyright (c) 2009, Yahoo! Inc. All rights reserved.
 Code licensed under the BSD License:
 http://developer.yahoo.net/yui/license.txt
 version: 3.0.0
 build: 1549
 */
YUI.add('io-upload-iframe',function(Y){var w=Y.config.win;function _addData(f,s){var o=[],m=s.split('='),i,l;for(i=0,l=m.length-1;i<l;i++){o[i]=document.createElement('input');o[i].type='hidden';o[i].name=m[i].substring(m[i].lastIndexOf('&')+1);o[i].value=(i+1===l)?m[i+1]:m[i+1].substring(0,(m[i+1].lastIndexOf('&')));f.appendChild(o[i]);Y.log('key: '+o[i].name+' and value: '+o[i].value+' added as form data.','info','io');}
return o;}
function _removeData(f,o){var i,l;for(i=0,l=o.length;i<l;i++){f.removeChild(o[i]);}}
function _setAttrs(f,id,uri){var ie8=(document.documentMode&&document.documentMode===8)?true:false;f.setAttribute('action',uri);f.setAttribute('method','POST');f.setAttribute('target','ioupload'+id);f.setAttribute(Y.UA.ie&&!ie8?'encoding':'enctype','multipart/form-data');}
function _resetAttrs(f,a){var p;for(p in a){if(a.hasOwnProperty(a,p)){if(a[p]){f.setAttribute(p,f[p]);}
else{f.removeAttribute(p);}}}}
function _create(o,c){var i=Y.Node.create('<iframe id="ioupload'+o.id+'" name="ioupload'+o.id+'" />');i._node.style.position='absolute';i._node.style.top='-1000px';i._node.style.left='-1000px';Y.one('body').appendChild(i);Y.on("load",function(){_handle(o,c)},'#ioupload'+o.id);}
function _handle(o,c){var d=Y.one('#ioupload'+o.id).get('contentWindow.document'),b=d.one('body'),xml=(d._node.nodeType===9),p;if(c.timeout){_clearTimeout(o.id);}
if(b){p=b.query('pre:first-child');o.c.responseText=p?p.get('innerHTML'):b.get('innerHTML');Y.log('The responseText value for transaction '+o.id+' is: '+o.c.responseText+'.','info','io');}
else if(xml){o.c.responseXML=d._node;Y.log('The response for transaction '+o.id+' is an XML document.','info','io');}
Y.io.complete(o,c);Y.io.end(o,c);w.setTimeout(function(){_destroy(o.id);},0);}
function _startTimeout(o,c){Y.io._timeout[o.id]=w.setTimeout(function(){var r={id:o.id,status:'timeout'};Y.io.complete(r,c);Y.io.end(r,c);Y.log('Transaction '+o.id+' timeout.','info','io');},c.timeout);}
function _clearTimeout(id){w.clearTimeout(Y.io._timeout[id]);delete Y.io._timeout[id];}
function _destroy(id){Y.Event.purgeElement('#ioupload'+id,false);Y.one('body').removeChild(Y.one('#ioupload'+id));Y.log('The iframe transport for transaction '+id+' has been destroyed.','info','io');}
Y.mix(Y.io,{_upload:function(o,uri,c){var f=(typeof c.form.id==='string')?Y.config.doc.getElementById(c.form.id):c.form.id,fields,attr={action:f.getAttribute('action'),target:f.getAttribute('target')};_create(o,c);_setAttrs(f,o.id,uri);if(c.data){fields=_addData(f,c.data);}
if(c.timeout){_startTimeout(o,c);Y.log('Transaction timeout started for transaction '+o.id+'.','info','io');}
f.submit();Y.io.start(o.id,c);if(c.data){_removeData(f,fields);}
_resetAttrs(f,attr);return{id:o.id,abort:function(){var r={id:o.id,status:'abort'};if(Y.one('#ioupload'+o.id)){_destroy(o.id);Y.io.complete(r,c);Y.io.end(r,c);Y.log('Transaction '+o.id+' aborted.','info','io');}
else{Y.log('Attempted to abort transaction '+o.id+' but transaction has completed.','info','io');return false;}},isInProgress:function(){return Y.one('#ioupload'+o.id)?true:false;}}}});},'3.0.0',{requires:['io-base','node-base','event-base']});