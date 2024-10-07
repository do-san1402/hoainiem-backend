/**	STYLE SWITCHER
 *************************************************** **/
jQuery(document).ready(function() {
    "use strict";

    jQuery("#hideSwitcher, #showSwitcher").click(function() {

        if (jQuery("#showSwitcher").is(":visible")) {

            var _identifier = "#showSwitcher";
            jQuery("#switcher").animate({ "margin-left": "0px" }, 50).show();
            createCookie("switcher_visible", 'true', 365);

        } else {

            var _identifier = "#switcher";
            jQuery("#showSwitcher").show().animate({ "margin-left": "0" }, 500);
            createCookie("switcher_visible", 'false', 365);

        }

        jQuery(_identifier).animate({ "margin-left": "-500px" }, 50, function() {
            jQuery(this).hide();
        });

    });

    // REMOVE # FROM URL
    $("a[href='#']").on("click", (function(e) {
        e.preventDefault();
    }));

});

function setActiveStyleSheet(title) {
    var i, a, main;
    for (i = 0;
        (a = document.getElementsByTagName("link")[i]); i++) {
        if (a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
            a.disabled = true;
            if (a.getAttribute("title") == title) { a.disabled = false; }
        }
    }

}

function getActiveStyleSheet() {
    var i, a;
    for (i = 0;
        (a = document.getElementsByTagName("link")[i]); i++) {
        if (a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title") && !a.disabled) { return a.getAttribute("title"); }
    }

    return null;
}

function getPreferredStyleSheet() {
    var i, a;
    for (i = 0;
        (a = document.getElementsByTagName("link")[i]); i++) {
        if (a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("rel").indexOf("alt") == -1 && a.getAttribute("title")) {
            return a.getAttribute("title");
        }
    }

    return null;
}

function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + ";";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];

        while (c.charAt(0) == ' ') {
            c = c.substring(1, c.length);
        }

        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }

    return null;
}


/** ********************************************************************************************************** **/
/** ********************************************************************************************************** **/
/** ********************************************************************************************************** **/

/**
	@ON LOAD
**/
var switcher_visible = '';
window.onload = function(e) {

    // COLOR SCHEME
    var cookie = readCookie("style");
    var title = cookie ? cookie : getPreferredStyleSheet();
    setActiveStyleSheet(title);

    // SWITCHER OPEN|CLOSED
    if (switcher_visible != 'false') {
        jQuery("#showSwitcher").trigger('click');
    }

}