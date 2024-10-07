$(document).ready(function () {
    "use strict"; // Start of use strict
    //Highlight
    var snippets = document.querySelectorAll('.snippet');
    [].forEach.call(snippets, function (snippet) {
        snippet.firstChild.insertAdjacentHTML('beforebegin', '<button class="btn-snippet" data-clipboard-snippet>Copy</button>');
    });
    var clipboardSnippets = new ClipboardJS('[data-clipboard-snippet]', {
        target: function (trigger) {
            return trigger.nextElementSibling;
        }
    });
    clipboardSnippets.on('success', function (e) {
        e.clearSelection();
        showTooltip(e.trigger, 'Copied!');
    });
    clipboardSnippets.on('error', function (e) {
        showTooltip(e.trigger, fallbackMessage(e.action));
    });

    var btns = document.querySelectorAll('.btn-snippet');
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener('mouseleave', clearTooltip);
        btns[i].addEventListener('blur', clearTooltip);
    }

    function clearTooltip(e) {
        e.currentTarget.setAttribute('class', 'btn-snippet');
        e.currentTarget.removeAttribute('aria-label');
    }

    function showTooltip(elem, msg) {
        elem.setAttribute('class', 'btn-snippet tooltipped tooltipped-s');
        elem.setAttribute('aria-label', msg);
    }

    function fallbackMessage(action) {
        var actionMsg = '';
        var actionKey = (action === 'cut' ? 'X' : 'C');
        if (/iPhone|iPad/i.test(navigator.userAgent)) {
            actionMsg = 'No support :(';
        } else if (/Mac/i.test(navigator.userAgent)) {
            actionMsg = 'Press Ã¢Å’Ëœ-' + actionKey + ' to ' + action;
        } else {
            actionMsg = 'Press Ctrl-' + actionKey + ' to ' + action;
        }
        return actionMsg;
    }
    $('pre code').each(function (i, block) {
        hljs.highlightBlock(block);
    });
});