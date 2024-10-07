$(document).ready(function () {
    'use strict';

    $(".select-basic-single").select2({
        // placeholder: "Select One",
        // allowClear : true
    });
    $(".skill-type-select2").select2({
        closeOnSelect: false,
        templateResult:  function (state) {
            if (!state.id) {
              return state.text;
            }

            var $state = $(
                '<span>' + state.text + '<span class="close select2-close-button" onclick="event.stopPropagation(); event.preventDefault(); deleteSkillTypeOption('+ state.id + ')">&times;</span></span>'
            );
            return $state;
        },
        escapeMarkup: function(m) { return m; }
    });
    $(".certificate-type-select2").select2({
        closeOnSelect: false,
        templateResult:  function (state) {
            if (!state.id) {
              return state.text;
            }

            var $state = $(
                '<span>' + state.text + '<span class="close select2-close-button" onclick="event.stopPropagation(); event.preventDefault(); deleteCertificateTypeOption('+ state.id + ')">&times;</span></span>'
            );
            return $state;
        },
        escapeMarkup: function(m) { return m; }
    });


    $(".basic-multiple").select2();
    $(".placeholder-single").select2({
        placeholder: "Select a state",
        allowClear: true
    });
    $(".placeholder-multiple").select2({
        placeholder: "Select a state"
    });
    $(".theme-single").select2();
    $(".language").select2({
        language: "es"
    });
    $(".js-programmatic-enable").on("click", function () {
        $(".js-example-disabled").prop("disabled", false);
        $(".js-example-disabled-multi").prop("disabled", false);
    });
    $(".js-programmatic-disable").on("click", function () {
        $(".js-example-disabled").prop("disabled", true);
        $(".js-example-disabled-multi").prop("disabled", true);
    });
});
