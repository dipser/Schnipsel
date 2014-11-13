

window.we_cmd("new","tblFile","","text/webedition");
window.we_cmd("new","tblFile","","folder");
window.we_cmd("new","tblTemplates","","text/weTmpl");
window.we_cmd("new","tblTemplates","","folder");

window.menuaction('new_html_page')
window.menuaction('new_javascript')
window.menuaction('new_css_stylesheet')
window.menuaction('new_template')
window.menuaction('new_object')
window.menuaction('new_ClObjectFile1')
parent.menuaction('new_webEditionPage')
window.menuaction('new_document_folder')
window.menuaction('new_template_folder')
window.menuaction('new_objectfile_folder')
window.menuaction('import')
window.menuaction('browse_server')
window.menuaction('info')
window.menuaction('showerrorlog')
window.menuaction('editThumbs')
window.menuaction('editCat')
window.menuaction('openPreferences')
window.menuaction('home')
window.menuaction('edit_navigation_ifthere')
window.menuaction('new_widget_usr')

window.info('ID:4 h')

toggleTree()


jsWindow: function jsWindow(url, ref, x, y, w, h, openAtStartup, scroll, hideMenue, resizable, noPopupErrorMsg, noPopupLocation, BrowserCrashedErrorMsg)

jsWindowOpen(noPopupErrorMsg, noPopupLocation)

openWindow(url, ref, x, y, w, h, scrollbars, menues)
openBrowser(url)







var tbl = [ 'tblFile', 'tblTemplates', 'tblObjectFiles', tblObject' ];
var t = window.rframe.we_tabs;
for(var i in t) {
	if (t[i].state==2){
		//console.log(i);
		if (i===0) { parent.menuaction('new_html_page'); }
	}
}

object.addEventListener ("keyup", handler, useCapture);
function detectspecialkeys(e){
var evtobj=window.event? event : e
if (evtobj.altKey || evtobj.ctrlKey || evtobj.shiftKey)
alert("you pressed one of the 'Alt', 'Ctrl', or 'Shift' keys")
}
var unicode=evtobj.charCode? evtobj.charCode : evtobj.keyCode
var actualkey=String.fromCharCode(unicode)
if (actualkey=="a")


