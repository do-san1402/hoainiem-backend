var BarcodeScannerEvents = function() {
    this.initialize.apply(this, arguments);
};

BarcodeScannerEvents.prototype = {
    initialize: function() {
        $(document).on({
            keypress: $.proxy(this._keypress, this)
        });
    },
    _timeoutHandler: 0,
    _inputString: '',
    _keypress: function (e) {
        if (this._timeoutHandler) {
            clearTimeout(this._timeoutHandler);
        }

        // Check for a printable character (exclude control characters)
        if (e.which >= 32 && e.which <= 126) {
            this._inputString += String.fromCharCode(e.which);
        }

        this._timeoutHandler = setTimeout($.proxy(function () {
            if (this._inputString.length > 2) {
                $(document).trigger('onbarcodescaned', this._inputString);
            }

            this._inputString = '';
        }, this), 20);
    }
};

new BarcodeScannerEvents();
