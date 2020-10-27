/**
 * Bootstrap Touch Nav: double Tap to open dropdown
 */

window.touched_start = 0;
window.touched = null;
document.addEventListener('DOMContentLoaded', function(event) {

    var bsdropdowns = document.querySelectorAll('.navbar .menu-item.dropdown');
    bsdropdowns.forEach((item, index) => {
        
        item.addEventListener('mouseover', function(e) {
            menu_dropdown_show(item);
        });
        item.addEventListener('mouseout', function(e) {
            menu_dropdown_hide(item);
        });

        item.addEventListener('touchstart', function(e) {
            window.touched_start = +new Date;
            console.log('touched start');
        });
        item.addEventListener('touchend', function(e) {
            console.log('touched end');
            let diff = (+new Date) - window.touched_start;


            // if item touched again -> goto link
            if ( window.touched != null && window.touched == item && item.contains(e.target) ) {
                // do nothing
            }
            // if item touched first time
            else {

                // if item touched -> open item and close prev touched item
                if ( item.contains(e.target) ) {
                    e.preventDefault();
                    if (window.touched != null) menu_dropdown_hide(window.touched);
                    window.touched = item;
                    menu_dropdown_show(item);
                }
                else {
                    window.touched = null;
                    menu_dropdown_hide(item);
                }
            }

            window.touched_start = 0;

        });

    });


    document.querySelector('.navbar-toggler').addEventListener('touchend', function() {
        if (window.touched != null) {
            menu_dropdown_hide(window.touched);
            window.touched = null;
        }
    });

});

function menu_dropdown_show(item) {
    item.classList.add('show');
    item.querySelector(':scope > a').setAttribute('aria-expanded', 'true');
    item.querySelector(':scope > ul.dropdown-menu').classList.add('show');
}
function menu_dropdown_hide(item) {
    item.classList.remove('show');
    item.querySelector(':scope > a').setAttribute('aria-expanded', 'false');
    item.querySelector(':scope > ul.dropdown-menu').classList.remove('show');
}
