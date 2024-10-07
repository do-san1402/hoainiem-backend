<?php
if (!session_get('db_configuration')) { ?>
    <script>
        window.location.href = './?a=db_configuration';
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
        <form action="#" method="post" id="admin-config">
            <input type="hidden" name="action" value="admin-config">
            <div class="form-group">
                <label for="email">Admin Email </label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Admin Email" required>
            </div>
            <div class="form-group">
                <label for="password">Admin Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Admin Password" required>
            </div>
            <div class="text-center">
                <button type="submit" id="admin-config-btn" class="btn btn-sm btn-success">Submit</button>
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
        <a href="./?a=db_configuration" class="btn btn-success pull-left aiia-wizard-button-previous" id="previous-btn"><span>Previous</span></a>

        <button class="btn btn-success pull-right aiia-wizard-button-next" title="You must fix the issue first" disabled><span>Finish</span></button>

    </div>
    <!-- /.End of step three -->
</div>