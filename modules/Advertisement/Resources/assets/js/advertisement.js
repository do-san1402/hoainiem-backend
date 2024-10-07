

    function addAdvDetails() {

        var url = $("#advertise_create").val();

        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: url,
            success: function(data) {
                var f_up_url = $("#advertise_store").val();

                var lang_add_advertise = $("#lang_add_advertise").val();

                $('.modal-title').text(lang_add_advertise);
                $('#projectDetailsForm').attr('action', f_up_url);
                $('.modal-body').html(data);

                $('#page').select2();
                $('#ad_type').select2();
                $('#position').select2();

                $('.img_ad').css({'display': 'none'});
                $('.embed_code_ad').css({'display': 'none'});

                $('#projectDetailsModal').modal('show');
            }
        });
    }

    $(document).ready(function() {
        "use strict";

         // Function to preview image
        $(document).on('change', '#ad_image', function(){
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function(e){
                $('#output').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });

        $(document).on("click", ".update-lg-status", function () {
            let url = $(this).data("route");
            let csrf = $(this).data("csrf");

            Swal.fire({
                title: get_phrases("Are you sure?"),
                text: get_phrases("You want to update status"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: url,
                        data: {
                            _token: csrf,
                            _method: "PUT",
                        },
                        success: function (data) {
                            $('#advertise-table').DataTable().ajax.reload();
                        },
                    });
                    Swal.fire("Updated!", "Status has been updated.", "success");
                }
            });
        });

        $(document).on("click", ".update-sm-status", function () {
            let url = $(this).data("route");
            let csrf = $(this).data("csrf");

            Swal.fire({
                title: get_phrases("Are you sure?"),
                text: get_phrases("You want to update status"),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: url,
                        data: {
                            _token: csrf,
                            _method: "PUT",
                        },
                        success: function (data) {
                            $('#advertise-table').DataTable().ajax.reload();
                        },
                    });
                    Swal.fire("Updated!", "Status has been updated.", "success");
                }
            });
        });


        $('.img_ad').css({'display': 'none'});
        $('.embed_code_ad').css({'display': 'none'});

    });

    function ad_type_change(ad_type){

        "use strict";

        if (ad_type == 1) {
            $('.img_ad').css({'display': 'none'});
            $('.embed_code_ad').css({'display': 'block'});
        }
        else if (ad_type == 2) {
            $('.img_ad').css({'display': 'block'});
            $('.embed_code_ad').css({'display': 'none'});
        }
        else {
            $('.img_ad').css({'display': 'none'});
            $('.embed_code_ad').css({'display': 'none'});
        }
    }


    function editAdvDetails(id, page, ad_position) {

        var url = $("#advertise_edit").val();
        url = url.replace(':advertise', id);

        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: url,
            success: function(data) {
                var up_url = $("#advertise_update").val();
                f_up_url = up_url.replace(':advertise', id);

                var lang_update_advertise = $("#lang_update_advertise").val();

                $('.modal-title').text(lang_update_advertise);
                $('#projectDetailsForm').attr('action', f_up_url);
                $('.modal-body').html(data);

                loadPagePositionsOnEdit(page);
                $('#position').trigger('change').val(ad_position);

                $('#page').select2();
                $('#position').select2();
                $('#ad_type').select2();

                $('.img_ad').css({'display': 'none'});
                $('.embed_code_ad').css({'display': 'none'});

                $('#projectDetailsModal').modal('show');
            }
        });
    }

    //for ad provide
    var pages = {
        '1': 'Home Page',
        '2':'Category Page',
        '3':'News Details Page'
    };

    var page_positions = {
        // for home page
        '11': 'Home Page Ads Position One (01)',
        '12': 'Home Page Ads Position Two (02)',
        '13': 'Home Page Ads Position Three (03)',
        '14': 'Home Page Ads Position Four (04)',
        '15': 'Home Page Ads Position Five (05)',
        '16': 'Home Page Ads Position Six (06)',
        '17': 'Home Page Ads Position Seven (07)',
        '18': 'Home Page Ads Position Eight (08)',

        // for Category page
        '21': 'Category Page Ads Position One (01)',
        '22': 'Category Page Ads Position Two (02)',
        '23': 'Category Page Ads Position Three (03)',
        '24': 'Category Page Ads Position Four (04)',

        // for News details page
        '31': 'News Details Page Ads Position One (01)',
        '32': 'News Details Page Ads Position Tow (02)',
        '33': 'News Details Page Ads Position Three (03)',
        '34': 'News Details Page Ads Position Four (04)',
        '35': 'News Details Page Ads Position Five (05)',
        '36': 'News Details Page Ads Position Six (06)'
    };

    function view_ad_pages(selected){

        "use strict";

        for(var key in pages){
                if(selected===key){
        document.write('<option value='+key+' selected>'+pages[key]+'</option>');
                }
                else{
        document.write('<option value='+key+'>'+pages[key]+'</option>');
                }
        }
    }


    function loadPagePositions(page_id,selected){
        "use strict";

        document.getElementById('position').innerHTML='<option value="">Select</option>';

        for(var key in page_positions){
            if(key.substring(0,1)===page_id){
                if(selected===key){
                    document.getElementById('position').innerHTML+=('<option value='+key+' selected>'+page_positions[key]+'</option>');
                }
                else{
                    document.getElementById('position').innerHTML+=('<option value='+key+'>'+page_positions[key]+'</option>');
                }

            }
            $('#position').select2();
        }
    }

    function loadPagePositionsOnEdit(page_id){
        "use strict";

        document.getElementById('position').innerHTML='<option value="">Select</option>';

        for(var key in page_positions){
            if(parseInt(key.substring(0,1))===page_id){
                document.getElementById('position').innerHTML+=('<option value='+key+'>'+page_positions[key]+'</option>');
            }
            $('#position').select2();
        }
    }

