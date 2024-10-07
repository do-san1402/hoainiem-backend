<!-- Fonts -->
<link
    href="{{ asset('backend/assets/dist/css/barlow-font.css') }}" rel="stylesheet" />


<!--Global Styles(used by all pages)-->

@if (app_setting()->rtl_ltr == 1)
    <link id="bt_css" href="{{ asset('backend/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
@else
    <link id="bt_css" href="{{ asset('backend/assets/plugins/bootstrap/css/bootstrap.rtl.min.css') }}"
        rel="stylesheet">
@endif
<link href="{{ asset('backend/assets/plugins/metisMenu/metisMenu.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/typicons/src/typicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/themify-icons/themify-icons.min.css') }}" rel="stylesheet">

<link href="{{ asset('backend/assets/dist/css/flag-icon.css') }}" rel="stylesheet">
<link id="dt_css" href="{{ asset('backend/assets/plugins/datatables/dataTables.bootstrap.min.css') }}"
    rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/datatables/responsive.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/jquery-ui-1.13.2/jquery-ui.min.css') }}" rel="stylesheet" />
<link href="{{ asset('backend/assets/plugins/jquery-ui-timepicker-addon.min.css') }}" rel="stylesheet" />

<link href="{{ asset('backend/assets/plugins/icheck/skins/all.css') }}" rel="stylesheet">

<!--Start Date Time Picker-->
<link href="{{ asset('backend/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/datetimepicker/jquery.datetimepicker.css') }}" rel="stylesheet">
<!--End Date Time Picker-->


<!--Start Bootstrap Toggle-->
<link href="{{ asset('backend/assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
<!--End Bootstrap Toggle-->

<link href="{{ asset('backend/assets/plugins/dropzone-5.7.0/dropzone.min.css') }}" rel="stylesheet">

<!--Start Your Custom Style Now-->
<link href="{{ asset('backend/assets/image-preview.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/assets/plugins/wickedpicker.min.css') }}" rel="stylesheet" />
@if (app_setting()->rtl_ltr == 1)
    <link id="st_css" href="{{ asset('backend/assets/dist/css/style.css') }}" rel="stylesheet">
    <link id="st_css" href="{{ asset('backend/assets/dist/css/new_custom_style.css') }}" rel="stylesheet">
@else
    <link id="st_css" href="{{ asset('backend/assets/dist/css/style.rtl.css') }}" rel="stylesheet">
@endif

<link href="{{ asset('backend/assets/custom-new.css') }}" rel="stylesheet" />
