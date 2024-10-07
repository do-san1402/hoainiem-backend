<?php
if (!session_get('requirement')) { ?>
    <script>
        window.location.href = '/?a=requirement';
    </script>
<?php
    exit();
}
?>
<h1>Envato License</h1>
<div class="row">
    <div class="col-md-12">
        <fieldset>
            <legend>Envato License</legend>
            <div class="row">
                <div class="col-md-12">
                    <?php if (get_purchase_data('purchase_key_used') && isset($_GET['status']) && $_GET['status']) { ?>

                        <a target="_blank" class="btn btn-warning pull-right" href="https://www.bdtask.com/license-update.php?<?php echo 'product_key=' . $envatoLic->get_product_key() . '&' . 'purchase_key=' . base64_encode(get_purchase_data('purchase_key')); ?>" role="button">Update Purchase Key</a>

                    <?php } ?>
                </div>
            </div>
            <form class="form-horizontal" method="POST" action="./">
                <input type="hidden" name="action" value="envato-license">
                <?php include __DIR__ . '/../error.php'; ?>
                <div class="form-group">
                    <label for="user_id" class="col-sm-4 col-form-label">Envato User ID <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Enter Envato User ID or Enter 'bdtask' as non Envato User">
                        </span> </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo @$_GET['user_id'] ?>" placeholder="User ID" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="purchase_key" class="col-sm-4 col-form-label">Purchase Key <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Enter Purchase Key which you got by envato purchase or bdtask support.">
                        </span></label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="purchase_key" value="<?php echo @$_GET['purchase_key'] ?>" name="purchase_key" placeholder="Purchase Key" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-4">
                        <button type="submit" class="btn btn-success btn-sm">Submit</button>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
    <div class="col-md-12 ">
        <br>
        <br>
        <a href="./?a=requirement" class="btn btn-success pull-left aiia-wizard-button-previous"><span>Previous</span></a>
    </div>
</div>