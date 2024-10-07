$('#logo').on('change', function() {
    var input = this;

    if (input.files && input.files[0]) {
        var reader = new FileReader(),
            filename = $("#logo").val(),
            filename = filename.substring(filename.lastIndexOf('\\') + 1);

        reader.onload = function(e) {
            const img = new Image();

            img.onload = function() {
                var size = input.files[0].size;
                var defaultImage = $('#image_preview').data("default_src");

             
                    $('#logo_preview').attr('src', e.target.result);
                    $('#logo_preview').hide();
                    $('#logo_preview').fadeIn(500);
            

                validator.element(input);
            }
            img.src = reader.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
});


$('#sidebar_logo').on('change', function() {
    var input = this;

    if (input.files && input.files[0]) {
        var reader = new FileReader(),
            filename = $("#sidebar_logo").val(),
            filename = filename.substring(filename.lastIndexOf('\\') + 1);

        reader.onload = function(e) {
            const img = new Image();

            img.onload = function() {
                var size = input.files[0].size;
                var defaultImage = $('#sidebar_logo_preview').data("default_src");

                    $('#sidebar_logo_preview').attr('src', e.target.result);
                    $('#sidebar_logo_preview').hide();
                    $('#sidebar_logo_preview').fadeIn(500);
         

                validator.element(input);
            }
            img.src = reader.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
});

$('#favicon').on('change', function() {
    var input = this;

    if (input.files && input.files[0]) {
        var reader = new FileReader(),
            filename = $("#favicon").val(),
            filename = filename.substring(filename.lastIndexOf('\\') + 1);

        reader.onload = function(e) {
            const img = new Image();

            img.onload = function() {
                var size = input.files[0].size;
                var defaultImage = $('#favicon_preview').data("default_src");

             
                    $('#favicon_preview').attr('src', e.target.result);
                    $('#favicon_preview').hide();
                    $('#favicon_preview').fadeIn(500);
           
                validator.element(input);
            }
            img.src = reader.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
});

$('#footer_logo').on('change', function() {
    var input = this;

    if (input.files && input.files[0]) {
        var reader = new FileReader(),
            filename = $("#footer_logo").val(),
            filename = filename.substring(filename.lastIndexOf('\\') + 1);

        reader.onload = function(e) {
            const img = new Image();

            img.onload = function() {
                var size = input.files[0].size;
                var defaultImage = $('#footer_logo_preview').data("default_src");

                    $('#footer_logo_preview').attr('src', e.target.result);
                    $('#footer_logo_preview').hide();
                    $('#footer_logo_preview').fadeIn(500);
         

                validator.element(input);
            }
            img.src = reader.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
});


$('#app_logo').on('change', function() {
    var input = this;

    if (input.files && input.files[0]) {
        var reader = new FileReader(),
            filename = $("#app_logo").val(),
            filename = filename.substring(filename.lastIndexOf('\\') + 1);

        reader.onload = function(e) {
            const img = new Image();

            img.onload = function() {
                var size = input.files[0].size;
                var defaultImage = $('#app_logo_preview').data("default_src");

                    $('#app_logo_preview').attr('src', e.target.result);
                    $('#app_logo_preview').hide();
                    $('#app_logo_preview').fadeIn(500);
         

                validator.element(input);
            }
            img.src = reader.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
});

$('#mobile_menu_image').on('change', function() {
    var input = this;

    if (input.files && input.files[0]) {
        var reader = new FileReader(),
            filename = $("#mobile_menu_image").val(),
            filename = filename.substring(filename.lastIndexOf('\\') + 1);

        reader.onload = function(e) {
            const img = new Image();

            img.onload = function() {
                var size = input.files[0].size;
                var defaultImage = $('#mobile_menu_image_preview').data("default_src");

                    $('#mobile_menu_image_preview').attr('src', e.target.result);
                    $('#mobile_menu_image_preview').hide();
                    $('#mobile_menu_image_preview').fadeIn(500);
         

                validator.element(input);
            }
            img.src = reader.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
});

$(document).ready(function () {
    let onValue = $('#fixed_date').prop('checked');
    if (onValue == true) {
        $('.fixed_date_show').show();
        $('input[name="fixed_date"]').attr('required', true);
    } else {
        $('.fixed_date_show').hide();
        $('input[name="fixed_date"]').removeAttr('required');
        $('input[name="fixed_date"]').val('');
    }
});

$('#fixed_date').change(function () {
    let onValue = $('#fixed_date').prop('checked');
    
    if (onValue == true) {
        $('.fixed_date_show').show();
        $('input[name="fixed_date"]').attr('required', true);
    } else {
        $('.fixed_date_show').hide();
        $('input[name="fixed_date"]').removeAttr('required');
        $('input[name="fixed_date"]').val('');
    }
});