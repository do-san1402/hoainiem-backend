<?php
if (!session_get('env_requirement')) { ?>
    <script>
        window.location.href = './?a=env_requirement';
    </script>
<?php
    exit();
}
$db_warning = false;
$env = readEnvFile();
?>
<div class="row">
    <fieldset>
        <legend>Database Configuration</legend>
        <form action="#" method="post" id="db-config">
            <input type="hidden" name="action" value="db-config">
            <div class="form-group">
                <label for="hostname">Host Name </label>
                <input type="text" name="DB_HOST" class="form-control" id="DB_HOST" placeholder="Host Name" value="<?php echo $env['DB_HOST'] ?>">
            </div>
            <div class="form-group">
                <label for="hostname">Host Port </label>
                <input type="text" name="DB_PORT" class="form-control" id="DB_PORT" placeholder="Host Name" value="<?php echo $env['DB_PORT'] ?>">
            </div>
            <div class="form-group">
                <label for="database">Database Name </label>
                <input type="text" name="DB_DATABASE" class="form-control" id="DB_DATABASE" placeholder="Database Name" value="<?php echo $env['DB_DATABASE'] ?>">
            </div>
            <div class="form-group">
                <label for="username">Username </label>
                <input type="text" name="DB_USERNAME" class="form-control" id="DB_USERNAME" placeholder="Username" value="<?php echo $env['DB_USERNAME'] ?>">
            </div>
            <div class="form-group">
                <label for="password">Password </label>
                <input type="password" name="DB_PASSWORD" class="form-control" id="DB_PASSWORD" placeholder="Password" value="<?php echo $env['DB_PASSWORD'] ?>">
            </div>
            <div class="text-center">
                <button type="submit" name="save_db_configuration" id="db-config-btn" class="btn btn-sm btn-success">Save</button>
            </div>

        </form>
    </fieldset>

    <div class="col-md-12">
        <div id="status"></div>
        <div id="timer"></div>
        <br />
        <br />
    </div>

    <div class="col-md-12">
        <a href="./?a=env_requirement" class="btn btn-success pull-left aiia-wizard-button-previous" id="previous-btn"><span>Previous</span></a>

        <button class="btn btn-success pull-right aiia-wizard-button-next" title="You must fix the issue first" disabled><span>Next</span></button>
    </div>
    <!-- /.End of step three -->
</div>