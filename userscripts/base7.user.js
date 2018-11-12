// ==UserScript==
// @name         Base7
// @namespace    http://vegvisir.de/
// @version      1.6.9
// @updateURL    https://raw.githubusercontent.com/dipser/Schnipsel/master/userscripts/base7.user.js
// @description  Trying to make Base7 better!
// @author       Aurelian Hermand
// @match        https://*.base7.io/*
// @match        https://*.base7booking.com/*
// @require      https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js
// @require      https://cdnjs.cloudflare.com/ajax/libs/arrive/2.4.1/arrive.min.js
// @grant        GM_*
// ==/UserScript==


// Wildcard-Matcher
function matchRuleShort(str, rule) {
  return new RegExp("^" + rule.split("*").join(".*") + "$").test(str);
}

(function() {
    'use strict';


    // Allgemeines Anzeigeelement
    var disablebrowserpagetext = '@page {size: auto;margin: 0mm;}';// html {background-color: #FFFFFF;margin: 0px; } body {margin: 10mm 15mm 10mm 15mm; }';
    var printstyle = '<style>'+disablebrowserpagetext+'@media print{ .no-print, .no-print * { display: none !important; } }</style>';
    $('body').append('<div id="monkeybox">-</div>'+printstyle);
    $("#monkeybox").css("position", "fixed").css("top", 0).css("right", 0).css('display', 'none');
    var checkin_checkout = function(t) {
        var months = {'Jan':'01', 'Feb':'02', 'Mär':'03', 'Apr':'04', 'Mai':'05', 'Jun':'06', 'Jul':'07', 'Aug':'08', 'Sep':'09', 'Okt':'10', 'Nov':'11', 'Dez':'12'};
        var time = t.split('-').map(function(i) { return i.trim(); });
        var cin = time[0].split(' ');
        var cout = time[1].split(' ');
        var checkout = cout[2] +'-'+ months[cout[1]] +'-'+ cout[0].padStart(2, '0');
        var checkin = cout[2] +'-'+ months[cin[1]] +'-'+ cin[0].padStart(2, '0');
        return [checkin, checkout];
    }


    // Aktuelle Seitenadresse
    var siteHref = window.location.pathname;

    // Vars
    var roomkeeping = {
        comments : false
    };

    window.setInterval(function(){
        siteHref = window.location.pathname;
        if ( matchRuleShort(siteHref, '/client/*') ) { // https://beta.base7booking.com/client/558
            //console.log('client');
            $("#monkeybox").css("display", "block");
        }
        else if( matchRuleShort(siteHref, '/today/sup/start/*') ) { // https://app.base7booking.com/today/sup/start/
            //console.log('housekeeping');
            $("#monkeybox").css("display", "block");
        }
        else {
            $("#monkeybox").css("display", "none");
        }
    }, 1000);


    // Ausfuehren wenn ein bestimmtes HTML existiert
    $(document).arrive('.component--page .page.module-client #client_details', {existing:true}, function(newElem) {
        //var $newElem = $(newElem);
        //console.log('new client');

        // Eingabefelder auslesen
        var client = {
            title: $('#client_details .sections select[name=title]').val(),
            company: $('#client_details .sections input[name=company]').val(),
            firstname: $('#client_details .sections input[name=firstname]').val(),
            lastname: $('#client_details .sections input[name=lastname]').val(),
            street: $('#client_details .sections input[name=address]').val(),
            postcode: $('#client_details .sections input[name=postcode]').val(),
            city: $('#client_details .sections input[name=city]').val(),
            countryNumber: $('#client_details .sections select[name=country]').val(),
            countryText: $('#client_details .sections select[name=country] option:selected').text()
        };
        client.countryCode = client.countryNumber>0 ? client.countryText.split('(')[1].split(')')[0] : '';

        // Eingabefelder Text zusammenfuegen
        var company = ((client.company.length>0)?client.company+'\n':'');
        var text = ''
            + company
            + client.firstname +' '+ client.lastname +'\n'
            + client.street +'\n'
            + client.countryCode +' - '+ client.postcode +' '+ client.city;

        var addressee = text.replace(/\r\n|\n/g, "%0A");

        // Ergebnistext im HTML ausgeben
        var price = $('#client_resa table.list td:nth-child(5)').text().trim();
        var room = $('#client_resa table.list td:nth-child(3)').text().trim(); // Number(('EZ01').match(/\d+$/)) => 1
        var str_rooms = room, spl_rooms = str_rooms.split(','), arr_rooms = []; for (let i in spl_rooms) { arr_rooms.push(Number((spl_rooms[i]).match(/\d+$/))); }
        var t = $('#client_resa table.list td:nth-child(2)').text().trim();
        var cc = checkin_checkout(t);
        var urlget = '?module_id=3&view=invoice&addressee='+addressee+'&guest='+client.firstname+' '+client.lastname+'&room='+arr_rooms.join(', ')+'&price='+price+'&date_checkin='+cc[0]+'&date_checkout='+cc[1];
        $('#monkeybox').html('<a href="http://hms.wolterdinger-hof.de/'+urlget+'" style="vertical-align:top;">&#8618;</a><textarea id="monkeycopy">'+ text +'</textarea>');
    });
    /*$(document).leave('.component--page .page.module-client #client_details', function() {
        var $removedElem = $(this);
        console.log('rem');
        $('#monkeybox').html('');
    });*/


    $(document).arrive('#roomkeeping h2.arrivals', {existing:true}, function(newElem) {
        console.log('roomkeeping...');

        var fnComments = function(){
            roomkeeping.comments = $(this).prop('checked');
            $('.arrivals tr.comment').css('display', (roomkeeping.comments) ? 'table-row' : 'none');
        };

        var fnAnreisePaper = function(){
            roomkeeping.anreisepaper = $(this).prop('checked');
            roomkeeping.comments = $('#monkeyroomkeepingcomments').prop('checked');
            if (roomkeeping.anreisepaper) { // Anreisezettel erstellen ...
                if (roomkeeping.comments) {
                    $('#monkeyroomkeepingcomments').prop('checked', false).trigger('change');
                }
                $('section:not(.hidden) .departures button.hide').trigger('click');
                $('section:not(.hidden) .stayvovers button.hide').trigger('click');
                $('section#top_extrainfo').hide();
                $('section#bottom_extrainfo').show();
            }
            else { // Anreisezettel entfernen ...
                $('section.hidden .departures button.hide').trigger('click');
                $('section.hidden .stayvovers button.hide').trigger('click');
                $('section#top_extrainfo').show();
                $('section#bottom_extrainfo').hide();
            }
        };
      
        // contentEditable of room-numbers
        let els = document.querySelectorAll(
          'table.departures tr:not([class=comment]) td:not([colspan]):nth-child(1), ' +
          'table.stayvovers tr:not([class=comment]) td:not([colspan]):nth-child(1), ' +
          'table.arrivals tr:not([class=comment]) td:not([colspan]):nth-child(1)'
        );
        for (let i = 0; i < els.length; i++) {
          els[i].setAttribute('contentEditable', 'true');
        }

        var html_displayComments = '<input type="checkbox" id="monkeyroomkeepingcomments" title="Kommentare ausblenden?" class="no-print">';
        var html_makeAnreisePaper = '<input type="checkbox" id="monkeyroomkeepinganreisepaper" title="Anreisezettel erzeugen?" class="no-print">';
        $('#monkeybox').html(html_displayComments + html_makeAnreisePaper);
        $('#monkeybox').on('change', '#monkeyroomkeepingcomments', fnComments).trigger('change');
        $('#monkeybox').on('change', '#monkeyroomkeepinganreisepaper', fnAnreisePaper).trigger('change');
        $('#monkeyroomkeepingcomments').trigger('change');

        var fsb_departures_count = 0;
        var fsb_stayovers_count = 0;
        var fsb_arrivals_count = 0;
        $('#roomkeeping table.departures tr > td:nth-child(4)').each(function(k,v){ var t = $(v).text().split('-'); fsb_departures_count += parseInt(t[0], 10) + parseInt(t[1], 10); });
        $('#roomkeeping table.stayvovers tr > td:nth-child(4)').each(function(k,v){ var t = $(v).text().split('-'); fsb_stayovers_count += parseInt(t[0], 10) + parseInt(t[1], 10); });
        $('#roomkeeping table.arrivals tr > td:nth-child(4)').each(function(k,v){ var t = $(v).text().split('-'); fsb_arrivals_count += parseInt(t[0], 10) + parseInt(t[1], 10); });
        var fsb_today = fsb_departures_count + fsb_stayovers_count;
        var fsb_tomorrow = fsb_stayovers_count + fsb_arrivals_count;

        var extrainfo = ''+
            '<section id="top_extrainfo"><table style="font-size:16px;border-top:1px solid grey;">'+
            '<tr style="border-bottom:1px solid grey;"><th style="width:170px;">Fr&uuml;hst&uuml;ck heute: </th><td contentEditable="true">'+fsb_today+' G&auml;ste</td></tr>'+
            '<tr style="border-bottom:1px solid grey;"><th>Fr&uuml;hst&uuml;ck morgen: </th><td contentEditable="true">'+fsb_tomorrow+' G&auml;ste</td></tr>'+
            '</table></section>';
        $('#roomkeeping h1').after(extrainfo);

        var bottom_extrainfo = ''+
            '<section id="bottom_extrainfo" style="margin-top:60px;display:none;font-size:2em;">'+
            '<h1 style="margin:0 0 15px 0;">Guten Tag,</h1>'+
            '<p style="margin:0 0 15px 0;font-size:0.7em;">bitte nehmen Sie sich Ihren zugeordneten Zimmerschl&uuml;ssel.<br>'+
            ''+
            '<p style="margin:0 0 15px 0;font-size:0.7em;" contentEditable="true">Bei Fragen: 0176 70006033</p>'+
            '<div style="text-align:center;"><img src="http://www.wolterdinger-hof.de/intern/res/img/Hotelplan-WolterdingerHof.png" height="450" alt="" /></div>'+
            '</section>';
        $('section .arrivals').parent().after(bottom_extrainfo);
    });


})();
