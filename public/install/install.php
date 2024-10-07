<?php
require_once __DIR__ . '/private/init.php';
require_once __DIR__ . '/include/header.php';
$current_link = $_GET['a'] ?? '';
$current_link_index = array_flip(array_keys($config['menu']))[$current_link] ?? 0;
?>

<body>
    <div class="page-wrapper">
        <div class="container">
            <!-- begin of row -->
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                    <header class="header">
                        <h1 class="header-title">Bdtask software installer</h1>
                    </header>
                    <div class="page-content">
                        <div class="outer-container">
                            <div class="aiia-wizard-progress-buttons-wrapper row" style="display: block;">
                                <div class="col-md-12">
                                    <ul class="nav nav-pills nav-justified aiia-wizard-progress-buttons-placeholder">
                                        <?php
                                        $si = 1;
                                        foreach ($config['menu'] as $link => $key) { ?>
                                            <li data-position="1" class="completed
                                            <?php
                                            if ($current_link == $link || ($si == 1 && $current_link == '')) {
                                                echo 'active';
                                            }
                                            ?>" style="padding: 0px 43px;">
                                                <a href="javascript:void(0);" <?php if (($si) <= $current_link_index) { ?> style="background-color: rgb(230, 230, 230);" <?php } ?>>
                                                    <h1>
                                                        <?php echo $si++ ?>.
                                                    </h1>
                                                    <?php echo $key ?>

                                                    <?php if (($si - 1) <= $current_link_index) { ?>
                                                        <span class="glyphicon glyphicon-ok-sign aiia-wizard-icon-step-completed" style="position: absolute; top: -20px; right: -17px; font-size: 4em; color: green;"></span>

                                                    <?php } ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <hr style="border-width: 4px; border-color: rgb(230, 230, 230);">

                            <?php
                            switch ($_GET['a'] ?? '') {
                                case 'requirement':
                                    require_once __DIR__ . '/include/card/requirement.php';
                                    break;
                                case 'envato_license':
                                    require_once __DIR__ . '/include/card/envato_license.php';
                                    break;
                                case 'env_requirement':
                                    require_once __DIR__ . '/include/card/env_requirement.php';
                                    break;
                                case 'db_configuration':
                                    require_once __DIR__ . '/include/card/db_configuration.php';
                                    break;
                                case 'admin_configuration':
                                    require_once __DIR__ . '/include/card/admin_configuration.php';
                                    break;
                                default:
                            ?>
                                    <script>
                                        window.location.href = '<?php echo get_root_url() ?>?a=requirement';
                                    </script>
                            <?php
                                    break;
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Footer include -->
    <?php require_once __DIR__ . '/include/footer.php'; ?>