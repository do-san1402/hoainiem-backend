<?php

/**
 * urlencode function
 *
 * @param  mixed  $string
 * @return string
 */
function u($string = '')
{
    return urlencode($string);
}

/**
 * rawurlencode function
 *
 * @param  mixed  $string
 * @return string
 */
function raw_u($string = '')
{
    return rawurlencode($string);
}

/**
 * htmlspecialchars function
 *
 * @param  mixed  $string
 * @return string
 */
function h($string = '')
{
    return htmlspecialchars($string);
}

/**
 * filter request
 *
 * @param  mixed  $title
 * @param  mixed  $data
 * @return bool|string
 */
function filter_request($title = null, $data = null)
{
    //if not empty posted data
    if (!empty($data)) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        // check if name only contains letters and numbers
        if (!preg_match('/^[A-Za-z0-9_-]+$/', $data)) {
            return "{$title} only alphabet, numbers and underscores may have";
        } else {
            //check first letter is number
            if (is_numeric(substr($data, 0, 1))) {
                return "{$title} first letter must be a character";
            } else {
                //if first letter is character
                return true;
            }
        }
    } else {
        return 'This fields are required';
    }
}

function filter_purchase_key($purchase_key)
{
    $length = strlen($purchase_key);
    if ($length >= 20 && $length <= 40) {
        return true;
    }

    return false;
}

/**
 * Check if the request is POST
 *
 * @return bool
 */
function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * Check Generated CSRF Token
 *
 * @return string
 */
function gen_csrf_token()
{
    $token                  = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;

    return $token;
}

/**
 * Check CSRF Token
 *
 * @param  string  $token
 * @return bool
 */
function check_csrf_token($token)
{
    if (isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token']) {
        return true;
    }

    return false;
}

/**
 * Session set
 *
 * @param  string  $key
 * @param  mixed  $vale
 * @return void
 */
function session_set($key, $vale)
{
    $_SESSION[$key] = $vale;
}

/**
 * Session get
 *
 * @param  mixed  $key
 * @return mixed
 */
function session_get($key)
{
    if (isset($_SESSION[$key])) {
        return $_SESSION[$key];
    }

    return null;
}

/**
 * Session Unset
 *
 * @param  mixed  $key
 * @return void
 */
function session_delete(string $key)
{
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}

/**
 * Session Flash
 *
 * @return mixed
 */
function session_flash(string $key, $value = null)
{

    if (isset($_SESSION[$key])) {
        $data = $_SESSION[$key];
        if ($value != null) {
            if (is_array($data)) {
                if (is_array($value)) {
                    $data = array_merge($data, $value);
                } else {
                    $data[] = $value;
                }
            } else {
                $data .= $value;
            }
            $_SESSION[$key] = $data;
        } else {
            session_delete($key);
        }

        return $data;
    }

    if ($value != null) {
        $_SESSION[$key] = $value;
    }

    return null;
}

/**
 * Check if the request is GET
 *
 * @return bool
 */
function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

/**
 * Check if the directory is writable
 *
 * @param  string  $dir
 * @param  string  $permission
 */
function check_dir_permission($dir, $permission = '777'): bool
{
    // dir if not exist create
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // give permission
    chmod($dir, 0777);
    // check permission
    if (substr(sprintf('%o', fileperms($dir)), -3) >= $permission) {
        return true;
    }

    return false;
}

/**
 * showing base directory
 *
 * @param  string  $file
 */
function base_dir($file): string
{
    return dirname(dirname(dirname(dirname(__FILE__)))) . '/' . $file;
}

/**
 * Read the contents of a .env file into an array
 *
 * @return array<string>
 */
function readEnvFile()
{
    $path = base_dir('.env');
    // Open the .env file for reading
    $file = fopen($path, 'r');
    // Initialize an empty array to store the keys and values
    $env = [];
    // Loop through each line in the file
    while (($line = fgets($file)) !== false) {
        // Ignore any comment lines
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        // Extract the key and value from the line
        $parts = explode('=', trim($line), 2);
        if (count($parts) !== 2) {
            continue;
        }
        $key   = $parts[0];
        $value = trim($parts[1], '"\''); // Remove quotes from value

        // Add the key and value to the array
        $env[$key] = $value;
    }
    // Close the file
    fclose($file);

    // Return the array
    return $env;
}

/**
 * Write an array of key/value pairs to a .env file
 *
 * @param  array<string>  $env
 */
function writeEnvFile(array $env): void
{
    $path = base_dir('.env');
    $str  = file_get_contents($path);

    //  replace the value of the specific key or create a new key
    foreach ($env as $key => $value) {
        // if value is true or false
        if ($value == 'true' || $value == 'false') {
            $key_value = "$key=$value";
        } else {
            $key_value = "$key=";
            if ($value && is_numeric($value)) {
                $key_value .= $value;
            } elseif ($value) {
                $key_value .= "\"$value\"";
            }
        }
        // check if key exists
        if (strpos($str, $key) !== false) {
            $str = preg_replace("/^$key=.*/m", $key_value, $str);
        } else {
            $str .= $key_value . PHP_EOL;
        }
    }

    file_put_contents($path, $str);
}

/**
 * Create a install file to storage folder | To prevent re-installation
 */
function createInstallFile($file = 'message.txt', $message = ''): void
{
    // Define the filename and path
    $path = base_dir('storage/framework') . DIRECTORY_SEPARATOR;

    // Open the file for writing (create if it doesn't exist)
    $handle = fopen($path . $file, 'a');

    // Get the current date and time
    $date = date('Y-m-d H:i:s');

    // Write the date, time, and message to the file
    fwrite($handle, $date . ' - ' . $message . "\n");

    // Close the file
    fclose($handle);
}

/**
 * Check if the installed.txt file exists
 *
 * @return void
 */
function check_installed_file($file = 'storage/framework/installed.php')
{
    // Set the base URL
    $base_url = get_root_url();

    // Check if the installed.txt file exists
    if (file_exists(base_dir($file))) {
        // Redirect to the base URL
        header('Location: ' . $base_url);
        exit;
    }
}

/**
 * Get the base URL
 *
 * @return string
 */
function get_base_url()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $domain   = $_SERVER['HTTP_HOST'];

    return $protocol . '://' . $domain . '/';
}

/**
 * Get the root URL
 *
 * @return string
 */
function get_root_url()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $domain   = $_SERVER['HTTP_HOST'];
    $path     = $_SERVER['REQUEST_URI'];
    // remove if exist install/index.php in the path the remove from path
    $path = str_replace('install/index.php', '', $path);
    $path = str_replace('index.php', '', $path);

    return $protocol . '://' . $domain . $path;
}
/**
 * Open Json File
 *
 * @param  mixed  $filePath
 * @return mixed
 */
function open_json_file($filePath)
{
    @chmod($filePath, 0777);
    $jsonString = [];
    if (file_exists($filePath)) {
        $jsonString = file_get_contents($filePath);
        $jsonString = json_decode($jsonString, true);
    }

    return $jsonString ?? [];
}

/**
 * set purchase data
 *
 * @param  mixed  $path_info
 * @param  mixed  $key
 * @param  mixed  $value
 * @return mixed
 */
function set_purchase_data($key, $value, $path_info = 'storage/framework/envato/license.json')
{
    $filePath = base_dir($path_info);

    // check if file not exist then create new file
    if (!file_exists($filePath)) {
        $myfile = fopen($filePath, 'w') or exit('Unable to open file!');
        $txt = '{}';
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    $infoArray = open_json_file($filePath);
    if (@array_key_exists($key, $infoArray)) {
        $infoArray[$key] = $value;
    } else {
        $infoArray[$key] = $value;
    }

    $jsonData = json_encode($infoArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $respo    = @file_put_contents($filePath, stripslashes($jsonData));

    return $infoArray[$key];
}

/**
 * get purchase data
 *
 * @param  mixed  $key
 * @param  mixed  $path_info
 * @return mixed
 */
function get_purchase_data($key, $path_info = 'storage/framework/envato/license.json')
{
    $filePath = base_dir($path_info);
    // check if file not exist then create new file
    if (!file_exists($filePath)) {
        $myfile = fopen($filePath, 'w') or exit('Unable to open file!');
        $txt = '{}';
        fwrite($myfile, $txt);
        fclose($myfile);
    }
    $infoArray = open_json_file($filePath);

    if (@array_key_exists($key, $infoArray)) {
        return $infoArray[$key];
    }

    return false;
}

/**
 * clear purchase data
 *
 * @param  mixed  $path_info
 * @return bool
 */
function clear_purchase_data($path_info = 'storage/framework/envato/license.json')
{
    $filePath  = base_dir($path_info);
    $infoArray = open_json_file($filePath);

    $infoArray = ['sl' => 1];
    $jsonData  = json_encode($infoArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $respo     = file_put_contents($filePath, stripslashes($jsonData));
    if ($respo) {
        return true;
    }

    return false;
}

/**
 * Check if the current request is using HTTPS
 *
 * @return bool
 */
function is_https()
{
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
        return true;
    } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }

    return false;
}

/**===============================================
 * Envato API
 * ==============================================*/

function envato_request_validate($data)
{
    $message = null;
    // validation for each posted data
    $user_id      = filter_request('User ID', $data['user_id']);
    $purchase_key = filter_request('Purchase Key', $data['purchase_key']);
    // check if user id and purchase key is valid
    if (is_string($user_id)) {
        $message .= "$user_id";
    }
    if (is_string($purchase_key)) {
        $message .= "$purchase_key";
    }
    if ($message) {
        session_flash('error', [$message]);
        header('location: ./?a=envato_license');
    }
}

/*======================================
Write .env file
======================================== */

function fix_env()
{
    writeEnvFile([
        'APP_ENV'   => 'production',
        'APP_DEBUG' => 'false',
        'APP_URL'   => get_root_url(),
    ]);
}

function create_symlink()
{
    $url = get_root_url() . 'dev/artisan-http/storage-link';
    // visit the url
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $output = curl_exec($ch);
    curl_close($ch);
}
