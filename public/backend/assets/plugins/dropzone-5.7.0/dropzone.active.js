$(document).ready(function () {
    "use strict"; // Start of use strict
    Dropzone.autoDiscover = false;
    Dropzone.options.dropzoneForm = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 10 // MB
    };
});