
    function addCategoryDetails() {

        var url = $("#category_create").val();

        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: url,
            success: function(data) {
                var f_up_url = $("#category_store").val();

                var lang_add_category = $("#lang_add_category").val();

                $('.modal-title').text(lang_add_category);
                $('#projectDetailsForm').attr('action', f_up_url);
                $('.modal-body').html(data);
                
                $('#category_topic').select2();
                $('#category_type').select2();

                $('#projectDetailsModal').modal('show');
            }
        });
    }

    $(document).ready(function() {
        "use strict";

         // Function to preview image
        $(document).on('change', '#category_image', function(){
            var file = $(this)[0].files[0];
            var reader = new FileReader();
            reader.onload = function(e){
                $('#output').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });

        $(document).on("click", ".img-status-change", function () {
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
                            $('#category-table').DataTable().ajax.reload();
                        },
                    });
                    Swal.fire("Updated!", "Status has been updated.", "success");
                }
            });
        });

    });


    function editCategoryDetails(id) {

        var url = $("#category_edit").val();
        url = url.replace(':category', id);

        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: url,
            success: function(data) {
                var up_url = $("#category_update").val();
                f_up_url = up_url.replace(':category', id);

                var lang_update_category = $("#lang_update_category").val();

                $('.modal-title').text(lang_update_category);
                $('#projectDetailsForm').attr('action', f_up_url);
                $('.modal-body').html(data);
                
                $('#category_topic').select2();
                $('#category_type').select2();

                $('#projectDetailsModal').modal('show');
            }
        });
    }
