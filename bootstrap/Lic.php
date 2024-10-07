<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class Lic extends Middleware
{
    // Domain Url/name
    private $domain;

    // Full Domain Url/name
    private $full_domain;

    // Expire Date
    private $expire_date;

    // Update Day
    private $update_day;

    // Purchase Key
    private $purchase_key;

    // Product Key
    private $product_key = '777888999';

    // License Key
    private $whitelist = [];

    // api domain
    private $api_domain = 'secure.bdtask.com';

    // log path
    private $log_path;
    //
    private $is_https = 0;
    // api url
    private $api_url = 'https://secure.bdtask.com/alpha/class.licencenew.php';

    public function __construct()
    {
        $timezone = date_default_timezone_get();
        date_default_timezone_set($timezone);
        // confirm session
        if (session_id() == '' || ! isset($_SESSION)) {
            session_start();
        }
        //set initial values
        $this->domain = $this->domain();
        // full domain
        $this->full_domain = $this->full_domain();
        //expire date
        $this->expire_date = @date('Y-m-d', @strtotime('+10 year'));
        //check day
        $this->update_day = @date('d');
        // get product key
        $this->product_key = $this->get_product_key();
        // get whitelist key
        $this->whitelist = $this->get_whitelist();
        // get purchase_key key
        $this->purchase_key = $this->get_purchase_key();
        // get api key
        $this->get_license_Key();
        // log path
        $this->log_path = storage_path('logs/license.log');
        $this->is_https = $this->is_https();
    }

    /**
     * Open Json File
     *
     * @param  string  $filePath
     * @return array
     */
    private function open_json_file($filePath)
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
     * get purchase data
     *
     * @return string|bool
     */
    private function get_purchase_data(string $key) : string|array
    {
        $filePath = storage_path('framework/envato/license.json');
        // check if file not exist then create new file
        if (! file_exists($filePath)) {
            $myfile = fopen($filePath, "w") or die("Unable to open file!");
            $txt = "{}";
            fwrite($myfile, $txt);
            fclose($myfile);
        }
        $lic = $this->open_json_file($filePath);

        if (@array_key_exists($key, $lic)) {
            return $lic[$key];
        }

        return false;
    }
    function set_purchase_data($key, $value, $path_info = 'framework/envato/license.json')
    {
        $filePath = storage_path($path_info);
        // check if file not exist then create new file
        if (! file_exists($filePath)) {
            $myfile = fopen($filePath, "w") or die("Unable to open file!");
            $txt = "{}";
            fwrite($myfile, $txt);
            fclose($myfile);
        }

        $infoArray = $this->open_json_file($filePath);
        if (@array_key_exists($key, $infoArray)) {
            $infoArray[$key] = $value;
        }
        else {
            $infoArray[$key] = $value;
        }

        $jsonData = json_encode($infoArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $respo    = @file_put_contents($filePath, stripslashes($jsonData));

        return $infoArray[$key];
    }

    /**
     * get product key
     */
    private function get_purchase_key() : ?string
    {
        return $this->get_purchase_data('purchase_key');
    }

    /**
     * get product key
     */
    private function get_product_key() : ?string
    {
        return $this->get_purchase_data('product_key');
    }

    /**
     * get license key
     */
    private function get_license_Key() : ?string
    {
        return $this->get_purchase_data('license_key');
    }

    /**
     * get whitelist
     */
    private function get_whitelist() : string|array
    {
        if (is_array($this->get_purchase_data('whitelist'))) {
            return $this->get_purchase_data('whitelist');
        }
        return [];
    }

    /**
     * Find the domain name
     *
     * @return string
     */
    private function domain()
    {
        $url = ($this->is_https() ? "https://" : "http://") . $_SERVER["HTTP_HOST"];
        $url .= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);

        // regex can be replaced with parse_url
        preg_match("/^(https|http|ftp):\/\/(.*?)\//", "$url/", $matches);

        if ((bool) ip2long($matches[2])) {
            return $matches[2];
        }
        else {
            $parts = explode(".", $matches[2]);
            $tld   = array_pop($parts);
            $host  = array_pop($parts);

            if (strlen($tld) == 2 && strlen($host) <= 3) {
                $tld  = "$host.$tld";
                $host = array_pop($parts);
            }

            return "$host.$tld";

        }
    }

    /**
     * Find the full domain name
     *
     * @return string
     */
    private function full_domain()
    {
        $url = ($this->is_https() ? "https://" : "http://") . $_SERVER["HTTP_HOST"];
        $url .= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);

        $details     = parse_url($url);
        $sub_folders = explode('/', $details['path']);

        $full_url = "";

        // if install in subfolder then take full_domian with that sub-folder
        if (sizeof($sub_folders) >= 2) {
            if ($sub_folders[1] == "install") {
                $full_url = $_SERVER["HTTP_HOST"] . '/';
            }
            else {
                $full_url = $_SERVER["HTTP_HOST"] . $details['path'];
                $full_url = str_replace("install/", "", $full_url);
            }
        }
        else {
            $full_url = $_SERVER["HTTP_HOST"] . '/';
        }

        return $full_url;
    }

    /**
     * Check if the purchase key is valid or not
     *
     * @param  string  $purchase_key
     * @return bool
     */
    public function validate_purchase_key($purchase_key)
    {
        $length = strlen($purchase_key);
        if ($length >= 20 && $length <= 40) {
            return true;
        }

        return false;
    }

    /**
     * Get the pre license
     *
     * @return string
     */
    private function get_pre_license()
    {
        return substr(hash('ripemd256', $this->domain), 0, 15);
    }

    /**
     * Encrypt the domain name
     *
     * @return string
     */
    private function domain_encryption()
    {
        $en_val = hash('sha256', $this->domain);

        return substr($en_val, 0, 10);
    }

    /**
     * Check if the request is https or not
     *
     * @return bool
     */
    private function is_https()
    {
        if (! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return 1;
        }
        elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
            return 1;
        }
        elseif (! empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return 1;
        }

        return 0;
    }

    /**
     * Check if the server is alive or not
     *
     * @return bool
     */
    private function serverAliveOrNot()
    {
        if ($pf = @fsockopen($this->api_domain, 443)) {
            fclose($pf);
            $_SESSION['serverAliveOrNot'] = true;

            return true;
        }
        else {
            $_SESSION['serverAliveOrNot'] = false;

            return false;
        }
    }


    /**
     * Verify the purchase key
     * @return bool
     */
    public function verify()
    {
        if (strpos('f267d344867154b0aea800760df617d9b32f2677815a85ae4f964a41886f32aa4e40fa', $this->domain_encryption())) {
            return true;
        }
        if (isset($_SESSION['refreshLic']) && $_SESSION['refreshLic'] == true) {
            // ip and domain whitelist
            $domain_encryption = $this->domain_encryption();
            if (in_array($domain_encryption, $this->whitelist)) {
                return true;
            }
        }
        $result                 = $this->check();
        $_SESSION['refreshLic'] = true;
        if ($result && ($result['msg'] === 'used' || $result['status'] === true)) {
            $domain_encryption = $this->domain_encryption();
            if (! in_array($domain_encryption, $this->whitelist)) {
                $this->whitelist[] = $domain_encryption;
                $this->set_purchase_data('whitelist', $this->whitelist);
            }
            return true;
        }
        else {
            $this->set_purchase_data('product_key', '');
            $this->set_purchase_data('purchase_key', '');
            $this->set_purchase_data('domain', '');
            $this->set_purchase_data('full_domain', '');
            $this->set_purchase_data('whitelist', []);
            $this->set_purchase_data('purchase_key_used', true);
            return false;
        }
    }

    /**
     * Check if the purchase key is valid or not
     *
     * @param  mixed  $purchase_key
     * @return mixed
     */
    public function check()
    {
        if ($this->purchase_key == null) {
            return false;
        }
        $url = "$this->api_url?product_key=$this->product_key&purchase_key=$this->purchase_key&domain=$this->domain&full_domain=$this->full_domain&http_check=$this->is_https&launch=1";
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, @$_SERVER['USER_AGENT']);

        return json_decode(curl_exec($ch), true);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->verify()) {
            return $next($request);
        }
        $alertHtml = '<script>
                    Swal.fire({
            icon: "error",
            title: "Oops...",
            html: "Your license has expired! <br/> This copy of application is not genuine <br/>Contact <a href=\"https://bdtask.com/#contact\" target=\"_blank\" style=\"color:#06b74c !important\">bdtask.com</a>",
            showConfirmButton: false,
            allowOutsideClick:false,
            closeOnEsc: false,
            });
        </script>';
        $response  = $next($request);
        $content   = $response->getContent();
        $content   = str_replace('</body>', $alertHtml . '</body>', $content);
        $response->setContent($content);

        return $response;

    }
}