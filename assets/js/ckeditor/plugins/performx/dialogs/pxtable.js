﻿(function(){var e;(function(d){d.ajax({async:!1,dataType:"json",url:CKEDITOR.plugins.getPath("performx")+"resources/tables.json",success:function(a){e=a.tables},error:function(a,b,c){console.log("Request Failed: "+(b+", "+c))}})})(jQuery);e.buildSelectList=function(){var d=[];d.push(["Choose a table...",""]);for(var a,b=0;b<this.length;b++)a=[this[b].displayName,this[b].tableValue],d.push(a);return d};e.getTableAttribute=function(d,a){for(var b=0;b<this.length;b++)if(this[b].tableValue==d)return this[b][a];
return""};CKEDITOR.dialog.add("pxTableDialog",function(d){return{title:"PerformX OpenAccess – Table Library",minWidth:470,minHeight:200,contents:[{id:"main",elements:[{type:"hbox",width:[null,null],height:180,children:[{type:"vbox",style:"margin-right: 20px;",children:[{id:"tableName",type:"select",label:"Table",items:e.buildSelectList(),onChange:function(){var a,b,c,d;a=this.getValue();b=CKEDITOR.plugins.getPath("performx");c=e.getTableAttribute(a,"previewImage");d=e.getTableAttribute(a,"displayName");
a=e.getTableAttribute(a,"description");""!=c?(c=b+"images/"+c,jQuery("#table-preview").html('<p style="margin-bottom:10px;white-space:normal;"><span style="font-weight:bold;color:#840004;">'+d+"</span><br/>"+a+'</p><img src="'+c+'" />')):jQuery("#table-preview").html('<img style="margin-top:30px;" src="'+CKEDITOR.plugins.getPath("performx")+'images/systemik-splash.png" />')}},{id:"rows",type:"text",label:"Rows",width:"50px",validate:CKEDITOR.dialog.validate.notEmpty("Rows number can't be empty."),
"default":"5"}]},{type:"vbox",children:[{id:"preview",type:"html",html:'<style type="text/css">#table-preview * {white-space:normal;}</style><div id="table-preview"></div>'}]}]},{type:"html",html:'<p><a style="color:#840004;" href="javascript:void(0);" id="pxTblHelpLink">Help</a>&nbsp;&nbsp;&nbsp;&nbsp;<a style="color:#840004;" href="javascript:void(0);" id="pxTblAboutLink">About</a></p>',onLoad:function(){document.getElementById("pxTblHelpLink").onclick=function(){window.pxHelpMode=2;d.openDialog("helpDialog")};
document.getElementById("pxTblAboutLink").onclick=function(){d.openDialog("aboutDialog")}}}]}],onShow:function(){jQuery("#table-preview").html('<img style="margin-top:30px;" src="'+CKEDITOR.plugins.getPath("performx")+'images/systemik-splash.png" />')},onOk:function(){var a=this.getValueOf("main","tableName"),b=this.getValueOf("main","rows"),c,f;c=e.getTableAttribute(a,"headHtml");f=e.getTableAttribute(a,"rowHtml");a=e.getTableAttribute(a,"footHtml");if(""!=f)for(var g=1;g<=b;g++){var h;h=f.replace("[?seq]",
g);c+=h}c+=a;""!=c&&d.insertHtml(c)}}})})();