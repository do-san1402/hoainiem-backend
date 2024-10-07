<?php
$requirement_warning = false;
$permission_warning = false;
?>
<h1>Server Requirements</h1>
<div class="row">
    <div class="col-md-12">
        <fieldset>
            <legend>Server Requirements</legend>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Server Requirements</th>
                        <th class='cwidth'>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>You have<strong> PHP
                                <?php echo $config['requirement']['php']; ?>
                            </strong> (or greater;
                            <strong>Current Version:
                                <?php echo phpversion(); ?>)
                            </strong>
                        </th>
                        <th>
                            <?php
                            if (version_compare(phpversion(), $config['requirement']['php'], '>=')) {
                            ?>
                                <span class="label label-success">Success</span>
                            <?php } else {
                                $requirement_warning = true;
                            ?>

                                <span class="label label-danger ">Failed</span>
                            <?php } ?>

                        </th>
                    </tr>
                    <?php
                    foreach ($config['requirement']['extension'] as $extension) {
                    ?>
                        <tr>
                            <th>You have the <strong>
                                    <?php echo $extension; ?>
                                </strong> extension</th>
                            <th>
                                <?php
                                if (extension_loaded($extension)) {
                                ?>
                                    <span class="label label-success">Success</span>
                                <?php } else {
                                    $requirement_warning = true;
                                ?>

                                    <span class="label label-danger ">Failed</span>
                                <?php } ?>

                            </th>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th>mod_rewrite is enabled</th>
                        <th>
                            <?php
                            if ($config['requirement']['apache']['mod_rewrite']) {
                            ?>
                                <span class="label label-success">Success</span>
                            <?php } else {
                                $requirement_warning = true;
                            ?>

                                <span class="label label-danger ">Failed</span>
                            <?php } ?>

                        </th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php if ($requirement_warning) { ?>
                                <div class='alert alert-danger'>
                                    <strong>Warning!</strong> Your server does not meet the requirements for
                                    install application.
                                </div>
                            <?php } else { ?>
                                <div class='alert alert-success'>
                                    <strong>Congratulations!</strong> Your server
                                    meets the requirements for install application.
                                </div>
                            <?php } ?>


                        </td>
                    </tr>

                </tbody>
            </table>
        </fieldset>
    </div>


    <div class=" col-sm-12">
        <fieldset>
            <legend>Directory permissions</legend>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th >Directory & Permissions</th>
                        <th class='cwidth'>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($config['dir_permission'] as $file => $dir) { ?>
                        <tr>
                            <th>
                                <?php echo $file; ?> is writeable
                            </th>
                            <th>
                                <?php
                                if (check_dir_permission($dir)) {
                                ?>
                                    <span class="label label-success">Success</span>
                                <?php } else {
                                    $permission_warning = true; ?>

                                    <span class="label label-danger ">Failed</span>
                                <?php } ?>

                            </th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2">
                            <?php if ($permission_warning) { ?>
                                <div class='alert alert-danger'>
                                    <strong>Warning!</strong> Your directory permission does not meet the
                                    requirements for
                                    install application.
                                </div>
                            <?php } else { ?>
                                <div class='alert alert-success'>
                                    <strong>Congratulations!</strong> Your directory permission meets the
                                    requirements for install application.
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="height"></div>
        </fieldset>
    </div>

    <div class="col-md-12">
        <?php if ($requirement_warning || $permission_warning) { ?>
            <button class="btn btn-success pull-right aiia-wizard-button-next" title="You must fix the issue first" disabled><span>Next</span></button>
        <?php
        } else {
            session_set('requirement', true);
        ?>
            <a class="btn btn-success pull-right aiia-wizard-button-next" href="./?a=envato_license"><span>Next</span></a>
        <?php } ?>
    </div>
</div>
