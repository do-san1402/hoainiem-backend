<?php

// check all ready ob_start and session_start
if (ob_get_level() == 0) ob_start(); // output buffering is turned on

// check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // session is turned on
}
require_once __DIR__ . '/function.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/EnvatoLicVerify.php';
$envatoLic = new EnvatoLicVerify();

/**
 * Check if the file is installed
 */
check_installed_file();

if (is_post_request()) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) {
        $data = $_POST;
    }
    switch ($data['action']) {
        case 'envato-license':
            envato_request_validate($data);
            $envatoLic->verify_purchase($data);
            break;
        case 'create .env file':
            //copy .env.example to .env
            copy(base_dir('.env.example'), base_dir('.env'));

            echo json_encode([
                'data' => [],
                'status' => true,
                'message' => '.env file created successfully',
            ]);
            break;
        case 'db-config':
            //copy .env.example to .env
            writeEnvFile([
                'DB_HOST' => $data['DB_HOST'],
                'DB_PORT' => $data['DB_PORT'],
                'DB_DATABASE' => $data['DB_DATABASE'],
                'DB_USERNAME' => $data['DB_USERNAME'],
                'DB_PASSWORD' => $data['DB_PASSWORD'],
            ]);
            $env = readEnvFile();
            if ($env['DB_HOST'] == '' || $env['DB_PORT'] == '' || $env['DB_DATABASE'] == '' || $env['DB_USERNAME'] == '') {
                echo json_encode([
                    'data' => [],
                    'status' => false,
                    'message' => '.env file not configured properly or permission denied. Please check your .env file.',
                ]);
                exit();
            }
            try {
                $connection = mysqli_connect($data['DB_HOST'], $data['DB_USERNAME'], $data['DB_PASSWORD'], $data['DB_DATABASE']);
            } catch (\Throwable $th) {
                echo json_encode([
                    'data' => [],
                    'status' => false,
                    'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error(),
                ]);
                exit();
            }

            // Check if the connection was successful
            if (mysqli_connect_errno()) {
                // Connection failed, print the error message
                echo json_encode([
                    'data' => [],
                    'status' => false,
                    'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error(),
                ]);
                exit();
            }
            //if db has tables
            $sql = 'SHOW TABLES FROM ' . $data['DB_DATABASE'];
            $result = mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo json_encode([
                    'data' => [],
                    'status' => false,
                    'message' => 'Database is not empty',
                ]);
                exit();
            }
            $sqlFile = base_dir('database/database.sql');

            // Read the SQL file into a string
            $sql = file_get_contents($sqlFile);
            // Execute the SQL commands
            if (mysqli_multi_query($connection, $sql)) {
                mysqli_close($connection);
                echo json_encode([
                    'data' => [],
                    'status' => true,
                    'message' => 'Database imported successfully',
                ]);
                session_set('db_configuration', true);
                exit();
            }
            mysqli_close($connection);
            echo json_encode([
                'data' => [],
                'status' => false,
                'message' => 'Database import failed',
            ]);
            // Close the database connection
            break;

        case 'admin-config':
            $env = readEnvFile();

            // connect to database
            $connect = mysqli_connect($env['DB_HOST'], $env['DB_USERNAME'], $env['DB_PASSWORD'], $env['DB_DATABASE'], intval($env['DB_PORT']));
            if (mysqli_connect_errno()) {
                echo json_encode([
                    'data' => [],
                    'status' => false,
                    'message' => 'Database connection failed. Please check your database config.',
                ]);
                exit();
            }
            // now create user to users table
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`uuid`, `full_name`, `user_name`, `email`, `password`, `user_type_id`, `email_verified_at`, `is_active`, `created_at`, `updated_at`) VALUES ('e96caced-b619-4713-a407-98bc8c40b6d1', 'Admin', 'admin', '{$data['email']}', '{$password}', 1, NOW(), 1, NOW(), NOW())";
            try {
                $result = mysqli_query($connect, $sql);
                if ($result) {
                    $user_id = mysqli_insert_id($connect);
                    $sql = "INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES (1, 'App\\\Models\\\User', {$user_id})";
                    $result = mysqli_query($connect, $sql);
                    if ($result) {
                        $envatoLic->response_success();
                        // fix env file
                        fix_env();
                        // create installed.txt file
                        createInstallFile('installed.php', 'Successfully installed');
                        // create symlink
                        create_symlink();

                        echo json_encode([
                            'data' => [],
                            'status' => true,
                            'message' => 'Admin created successfully',
                        ]);
                        session_set('admin_configuration', true);
                        exit();
                    }
                }
            } catch (\Throwable $th) {
                echo json_encode([
                    'data' => [],
                    'status' => false,
                    'message' => 'Admin creation failed. Please try again.',
                ]);
            }

            break;

        default:
            echo 'Invalid request';
            break;
    }
    exit();
}
