<?php
$error = session_flash('error');
if ($error) {
    if (is_array($error)) {
        echo '<div class="alert alert-danger">';
        foreach ($error as $key => $value) {
            echo "<li>$value</li>";
        }
        $purchase_key_used = session_flash('purchase_key_used');
        if ($purchase_key_used) {
            echo "<li> \n <a href=\"https://www.bdtask.com/license-update.php?product_key=20386502&purchase_key=$purchase_key_used\" target=\"_blank\" >Update Purchase Now</a> </li>";
        }
        echo '</ul>
        </div>';
    } else { ?>
        <div class="alert alert-danger">
            <li>
                <?php echo $error ?>
            </li>
            <?php
            $purchase_key_used = session_flash('purchase_key_used');
            if ($purchase_key_used) {
                echo "<li> \n <a href=\"https://www.bdtask.com/license-update.php?product_key=20386502&purchase_key=$purchase_key_used\" target=\"_blank\" >Update Purchase Now</a> </li>";
            } ?>
            </ul>
        </div>
<?php
    }
} ?>