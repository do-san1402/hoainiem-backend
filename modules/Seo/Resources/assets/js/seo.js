$(document).ready(function() {
    "use strict";

     // Function to preview image
    $(document).on('change', '#default_image', function(){
        var file = $(this)[0].files[0];
        var reader = new FileReader();
        reader.onload = function(e){
            $('#output').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
    });

});
