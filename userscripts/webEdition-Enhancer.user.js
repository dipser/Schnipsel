// ==UserScript==
// @name        webEdition Enhancer
// @namespace   wegmus
// @description webEdition Greasemonkey Userscript
// @include     /^https?://.*/webEdition/.*$/
// @require     http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.js
// @version     1.0.3
// @author      Aurel 'dipser' Hermand
// ==/UserScript==


$(function(){


    $(window).on('keypress', function(e){
        //console.log(e, window, top);
        var win = top;
        
        if (e.ctrlKey) { // Vorsicht: e.altKey liefert bei e.key andere Zeichen
            var key = e.key;
            
            // webEdition-Vorbelegung:
            // w = Schließen
            // s = Sichern
            // S = Veröffentlichen
            
            // Import (i)
            if (key == 'i') {
                win.menuaction('import');
            }
            
            // Info (I)
            if (key == 'I') {
                win.menuaction('info');
            }
            
            // Template (t)
            if (key == 't') {
                win.menuaction('new_template');
            }
            
            // Template-Dir (T)
            if (key == 'T') {
                win.menuaction('new_template_folder');
            }
            
            // Document (d)
            if (key == 'd') {
                win.menuaction('new_webEditionPage');
            }
            
            // Document-Folder (D)
            if (key == 'D') {
                win.menuaction('new_document_folder');
            }
            
            // Errors (e)
            if (key == 'e') {
                win.menuaction('showerrorlog');
            }
            
            // Categories (c)
            if (key == 'c') {
                win.menuaction('editCat');
            }
            
            // Miniaturansicht (m)
            if (key == 'm') {
                win.menuaction('editThumbs');
            }
            
            // Navigation (N)
            if (key == 'N') {
                //win.menuaction('edit_navigation_ifthere');
                win.we_cmd('edit_navigation');
            }
            
            // User (u)
            if (key == 'u') {
                win.menuaction('edit_users_ifthere');
            }
            
            // Find (f)
            if (key == 'f') {
                win.menuaction('tool_weSearch_edit');
            }
            
            // Preferences (p)
            if (key == 'p') {
                 win.menuaction('openPreferences');
            }

        }
    });
    

});
