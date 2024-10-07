<?php
if (!session_get('envato_license')) { ?>
    <script>
        window.location.href = './?a=envato_license';
    </script>
<?php
    exit();
}
$vendor_warning = false;
$env_warning = false;
?>

<h1>Environment Requirements</h1>
<div class="row">
    <div class="col-md-12">
        <?php if (!file_exists(base_dir('vendor'))) {
            $vendor_warning = true; ?>
            <div class='alert alert-danger'>
                <strong>Warning!</strong> Your application does not have vendor file.
            </div>

            <div class='alert alert-danger'>
                <strong>Warning!</strong> For Vendor File Contact Our Live Support.
            </div>
        <?php } else { ?>
            <div class='alert alert-success'>
                <strong>Congratulations!</strong> Your application has vendor file.
            </div>
        <?php } ?>

    </div>
    <?php if (!$vendor_warning) { ?>
        <div class="col-md-12">
            <?php if (!file_exists(base_dir('.env'))) {
                $env_warning = true; ?>
                <div class='alert alert-danger'>
                    <strong>Warning!</strong> Your application does not have .env file.
                    <a href="javascript:void(0)" class="btn btn-success btn-sm" id="create-env">Create ENV
                        File
                    </a>
                </div>
            <?php } else {
                $env_warning = false; ?>
                <div class='alert alert-success'>
                    <strong>Congratulations!</strong> Your application has .env file.
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="col-md-12">
        <div id="status"></div>
        <div id="timer"></div>
        <br />
        <br />
    </div>

    <div class="col-md-12">
        <a href="./?a=envato_license" class="btn btn-success pull-left aiia-wizard-button-previous" id="previous-btn"><span>Previous</span></a>

        <?php if ($vendor_warning || $env_warning) { ?>
            <button class="btn btn-success pull-right aiia-wizard-button-next" title="You must fix the issue first" disabled><span>Next</span></button>
        <?php
        } else {
            session_set('env_requirement', true);
        ?>
            <a class="btn btn-success pull-right aiia-wizard-button-next" href="./?a=db_configuration"><span>Next</span></a>
        <?php } ?>
    </div>
</div>