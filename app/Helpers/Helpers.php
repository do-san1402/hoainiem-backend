<?php

use App\Enums\AssetsFolderEnum;
use App\Enums\DateFormatEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Modules\Accounts\Entities\AccCoa;
use Modules\Accounts\Entities\AccVoucher;
use Modules\Localize\Entities\Language;
use Modules\Setting\Entities\Application;
use Modules\UserManagement\Entities\PerMenu;

/**
 * generate asset url
 */
function custom_asset(?string $file = null, ?string $default = null, ?string $path = null): string
{

    if ($file) {
        return app('url')->asset($path . '/' . $file . '?v=1');
    }

    return $default;
}

/**
 * module asset url
 */
function module_asset(?string $file = null, ?string $default = null): string
{
    return custom_asset($file, $default, 'module-assets');
}

if (!function_exists('age')) {
    function age($dob)
    {
        $age = Carbon::parse($dob)->age;
        return $age . " Years";
    }

}

function parentMenu($menuId)
{
    $menuDetail = PerMenu::where('id', $menuId)->first();

    if (empty($menuDetail)) {
        return null;
    }

    return $menuDetail->menu_name;
}

if (!function_exists('app_setting')) {
    function app_setting()
    {
        $appSetting = Cache::remember('appSetting', 3600, function () {
            return Application::with('currency')->first();
        });

        if (storage_path('app/public/' . $appSetting->logo) && file_exists(storage_path('app/public/' . $appSetting->logo))) {
            $appSetting->logo = asset('storage/' . $appSetting->logo);
        } else {
            $appSetting->logo = asset('assets/logo.png');
        }

        if (storage_path('app/public/' . $appSetting->sidebar_logo) && file_exists(storage_path('app/public/' . $appSetting->sidebar_logo))) {
            $appSetting->sidebar_logo = asset('storage/' . $appSetting->sidebar_logo);
        } else {
            $appSetting->sidebar_logo = asset('assets/logo.png');
        }

        if (storage_path('app/public/' . $appSetting->sidebar_collapsed_logo) && file_exists(storage_path('app/public/' . $appSetting->sidebar_collapsed_logo))) {
            $appSetting->sidebar_collapsed_logo = asset('storage/' . $appSetting->sidebar_collapsed_logo);
        } else {
            $appSetting->sidebar_collapsed_logo = asset('assets/mini-logo.png');
        }

        if (storage_path('app/public/' . $appSetting->favicon) && file_exists(storage_path('app/public/' . $appSetting->favicon))) {
            $appSetting->favicon = asset('storage/' . $appSetting->favicon);
        } else {
            $appSetting->favicon = asset('assets/favicon.png');
        }

        if (storage_path('app/public/' . $appSetting->login_image) && file_exists(storage_path('app/public/' . $appSetting->login_image))) {
            $appSetting->login_image = asset('storage/' . $appSetting->login_image);
        } else {
            $appSetting->login_image = asset('assets/logo.png');
        }

        if (storage_path('app/public/' . $appSetting->footer_logo) && file_exists(storage_path('app/public/' . $appSetting->footer_logo))) {
            $appSetting->footer_logo = asset('storage/' . $appSetting->footer_logo);
        } else {
            $appSetting->footer_logo = asset('assets/logo.png');
        }

        if (storage_path('app/public/' . $appSetting->app_logo) && file_exists(storage_path('app/public/' . $appSetting->app_logo))) {
            $appSetting->app_logo = asset('storage/' . $appSetting->app_logo);
        } else {
            $appSetting->app_logo = asset('assets/logo.png');
        }

        if (storage_path('app/public/' . $appSetting->mobile_menu_image) && file_exists(storage_path('app/public/' . $appSetting->mobile_menu_image))) {
            $appSetting->mobile_menu_image = asset('storage/' . $appSetting->mobile_menu_image);
        } else {
            $appSetting->mobile_menu_image = asset('assets/logo.png');
        }

        return $appSetting;
    }

}

// currencies
if (!function_exists('currency')) {
    function currency()
    {
        $currency = Cache::remember('currency', 3600, function () {
            return app_setting()?->currency->symbol ?? null;
        });
        return $currency;
    }

}

if (!function_exists('logo_64_data')) {
    function logo_64_data()
    {
        // Forever cache
        $appSetting = Cache::remember('appSetting', 3600, function () {
            return Application::first();
        });

        $logo = null;

        if (file_exists(asset($appSetting->logo))) {
            $logo = 'storage/' . $appSetting->logo;
        } else {
            $logo = __DIR__ . "/backend/assets/dist/img/logo-preview.png";
        }

        if (file_exists($logo) && is_readable($logo)) {
            $type   = pathinfo($logo, PATHINFO_EXTENSION);
            $data   = file_get_contents($logo);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            return $base64;
        } else {
            // Handle error here (e.g., log, return a placeholder image, etc.)
            return null;
        }

    }

}

if (!function_exists('lang_setting')) {
    function lang_setting()
    {
        return cache()->remember('lang_setting', 120, function () {
            return Language::all();
        });
    }

}

if (!function_exists('numberToWords')) {
    function numberToWords($number)
    {
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return ucwords($f->format($number) . ' ' . app_setting()->currency->title . ' ' . 'Only');
    }

}

if (!function_exists('numberToMillionBillion')) {
    function numberToMillionBillion($number = '')
    {

        if ($number >= 1000000000) {
            return number_format($number / 1000000000, 2) . 'B';
        } elseif ($number >= 1000000) {
            return number_format($number / 1000000, 2) . 'M';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 2) . 'K';
        } else {
            return number_format($number);
        }

    }

}

if (!function_exists('current_date')) {
    function current_date()
    {
        return Carbon::today()->toDateString();
    }

}

if (!function_exists('current_date_for_account')) {
    function current_date_for_account()
    {
        $startDate = Carbon::today()->format('d/m/Y');
        $endDate   = Carbon::today()->addDays(30)->subDay()->format('d/m/Y');

        return $startDate . ' - ' . $endDate;
    }

}

if (!function_exists('getVouchersByNo')) {
    function getVouchersByNo($voucher_no)
    {
        $vouchers = Cache::remember($voucher_no, 3600, function () use ($voucher_no) {
            return AccVoucher::where('voucher_no', $voucher_no)->get();
        });

        return $vouchers;
    }

}

if (!function_exists('orderByData')) {
    function orderByData($req = null)
    {
        $orderBY = "DESC";

        if ($req != null && ($req[0]["dir"] == "desc")) {
            $orderBY = "ASC";
        }

        return $orderBY;
    }

}

if (!function_exists('bt_number_format')) {
    function bt_number_format($number)
    {
        $type                 = app_setting()->floating_number;
        $negative_symbol_type = app_setting()->negative_amount_symbol;
        $negative             = false;

        if ($number < 0) {
            $negative = true;
            $number   = (float) $number * -1;
        }

        if ($type == 1) {

            if ($negative_symbol_type == 2) {

                if ($negative) {
                    return '(' . number_format((float) (preg_replace('/[^\d.]/', '', $number)), 0, '.', ',') . ')';
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 0, '.', ',');
                }

            } else {

                if ($negative) {
                    return number_format(-(float) (preg_replace('/[^\d.]/', '', $number)), 0, '.', ',');
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 0, '.', ',');
                }

            }

        } elseif ($type == 2) {

            if ($negative_symbol_type == 2) {

                if ($negative) {
                    return '(' . number_format((float) (preg_replace('/[^\d.]/', '', $number)), 1, '.', ',') . ')';
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 1, '.', ',');
                }

            } else {

                if ($negative) {
                    return number_format(-(float) (preg_replace('/[^\d.]/', '', $number)), 1, '.', ',');
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 1, '.', ',');
                }

            }

        } elseif ($type == 3) {

            if ($negative_symbol_type == 2) {

                if ($negative) {
                    return '(' . number_format((float) (preg_replace('/[^\d.]/', '', $number)), 2, '.', ',') . ')';
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 2, '.', ',');
                }

            } else {

                if ($negative) {
                    return number_format(-(float) (preg_replace('/[^\d.]/', '', $number)), 2, '.', ',');
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 2, '.', ',');
                }

            }

        } elseif ($type == 4) {

            if ($negative_symbol_type == 2) {

                if ($negative) {
                    return '(' . number_format((float) (preg_replace('/[^\d.]/', '', $number)), 3, '.', ',') . ')';
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 3, '.', ',');
                }

            } else {

                if ($negative) {
                    return number_format(-(float) (preg_replace('/[^\d.]/', '', $number)), 3, '.', ',');
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 3, '.', ',');
                }

            }

        } else {

            if ($negative_symbol_type == 2) {

                if ($negative) {
                    return '(' . number_format((float) (preg_replace('/[^\d.]/', '', $number)), 2, '.', ',') . ')';
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 2, '.', ',');
                }

            } else {

                if ($negative) {
                    return number_format(-(float) (preg_replace('/[^\d.]/', '', $number)), 2, '.', ',');
                } else {
                    return number_format((float) (preg_replace('/[^\d.]/', '', $number)), 2, '.', ',');
                }

            }

        }

    }

}

if (!function_exists('isBankNature')) {
    function isBankNature($id)
    {
        $nature = AccCoa::select('is_bank_nature', 'id')->where('id', $id)->where('is_bank_nature', 1)->first();

        if ($nature) {
            return true;
        } else {
            return false;
        }

    }

}

if (!function_exists('check_expiry')) {
    function check_expiry(string $expiry_date, int $interval = null): bool
    {
        $today = Carbon::today();

        if ($interval) {
            $interval_date = Carbon::today()->addDays($interval);
            $expiry        = Carbon::parse($expiry_date)->lte($interval_date);

            if ($expiry && Carbon::parse($expiry_date)->gt($today)) {
                return true;
            } else {
                return false;
            }

        } else {
            $expiry = Carbon::parse($expiry_date)->lt($today);
        }

        return $expiry;
    }

}

if (!function_exists('check_expiry')) {
    function check_expiry(string $expiry_date, int $interval = null): bool
    {
        $today = Carbon::today();

        if ($interval) {
            $interval_date = Carbon::today()->addDays($interval);
            $expiry        = Carbon::parse($expiry_date)->lte($interval_date);

            if ($expiry && Carbon::parse($expiry_date)->gt($today)) {
                return true;
            } else {
                return false;
            }

        } else {
            $expiry = Carbon::parse($expiry_date)->lt($today);
        }

        return $expiry;
    }

}

/**
 * Convert size to human readable format (KB, MB, GB, TB, PB)
 */
function size_convert(int $size): string
{
    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

/**
 * Activity Log Now
 *
 * @param  mixed  $user
 */
function logNow(array $response = [], string $name = 'Default', string $log = 'error', string $user = null): void
{

    if (!$user) {
        $user = auth()->user();
    }

    activity()
        ->causedBy($user)
        ->withProperties([
            'url'      => request()->fullUrl(),
            'method'   => request()->method(),
            'input'    => request()->all(),
            'response' => $response,
        ])
        ->useLog($name)
        ->log($log);
}

/**
 * Get The Localize Data From File
 */
function localize(?string $key, ?string $default_value = null, ?string $locale = null): ?string
{

    if (is_null($key) || $key == '' || $key == ' ' || empty($key)) {
        return '';
    }

    return \App\Facades\Localizer::localize($key, $default_value, $locale);
}

/**
 * Get The Localize Upper Case First Word
 */
function localize_uc(string $string): string
{
    return ucwords(localize($string));
}

/**
 * Get The Localize Upper Case First Word
 */
function localize_lower(string $string): string
{
    return strtolower(localize($string));
}

/**
 * Get The Localize Data From File
 */
function ___(?string $key, ?string $default_value = null, ?string $locale = null): ?string
{
    return localize($key, $default_value, $locale);
}

/**
 * Get The Localize Data From File
 */
function get_phrases(?string $key, ?string $default_value = null, ?string $locale = null): ?string
{
    return localize($key, $default_value, $locale);
}

if (!function_exists("makeString")) {

    function makeString($data = [])
    {
        $output = "";
        $i      = 0;

        foreach ($data as $val) {
            $output .= ($i > 0 ? " " : "");
            $output .= localize("$val");
            $i++;
        }

        return $output;
    }

}

if (!function_exists('generate_positions')) {

    function generate_positions($start, $end)
    {
        $positions = [];

        for ($i = $start; $i <= $end; $i++) {
            $positions[] = $i;
        }

        return $positions;
    }

}

if (!function_exists('get_date_picker_format')) {
    /**
     * Get date format for javascript
     *
     * @return string
     */
    function get_date_picker_format(): string
    {
        return DateFormatEnum::YYYY_MM_DD->value;
    }

}

if (!function_exists('get_date_format')) {
    /**
     * Get date format
     *
     * @return string
     */
    function get_date_format(): string
    {
        return DateFormatEnum::MM_DD_YYYY->value;
    }

}

/**
 * Return all public asset form public/assets folder
 */

if (!function_exists('assets')) {
    function assets($file = ''): string
    {
        return asset(AssetsFolderEnum::PUBLIC_ASSETS->value . '/' . $file);
    }

}

/**
 * Return all uploaded asset from public/storage
 */

if (!function_exists('storage_asset_image')) {
    function storage_asset_image($file = ''): string
    {

        if (!file_exists(storage_path('app/public/' . $file))) {
            return asset('/assets/default.jpg');
        }

        return asset(AssetsFolderEnum::STORAGE_ASSETS->value . '/' . $file);
    }

}

/**
 * Set success message
 *
 * @param string $message
 *
 * @return void
 */

if (!function_exists('success_message')) {

    function success_message(string $message): void
    {
        toast($message, 'success');
    }

}

/**
 * Set error message
 *
 * @param string $message
 *
 * @return void
 */

if (!function_exists('error_message')) {

    function error_message(string $message): void
    {
        toast($message, 'error');
    }

}

/**
 * Set warning message
 *
 * @param string $message
 *
 * @return void
 */

if (!function_exists('warning_message')) {

    function warning_message(string $message): void
    {
        toast($message, 'warning');
    }

}

/**
 * Write an array of key/value pairs to a .env file
 *
 * @param array $env
 *
 * @return void
 */

if (!function_exists('writeEnvFile')) {
    function writeEnvFile(array $env, $path = __DIR__ . '/../../.env'): void
    {
        $str = file_get_contents($path);

        /**
         * replace the value of the specific key or create a new key
         */

        foreach ($env as $key => $value) {

            /**
             * if value is true or false
             */

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

            /**
             * check if key exists
             */

            if (strpos($str, $key) !== false) {
                $str = preg_replace("/^$key=.*/m", $key_value, $str);
            } else {
                $str .= $key_value . PHP_EOL;
            }

        }

        file_put_contents($path, $str);
        // forget mail config cache
        \Illuminate\Support\Facades\Artisan::call('config:cache');
    }

}

/**
 * Check the existence of file in filesystem
 *
 * @param  string|null  $filename
 *
 * @return bool|false
 */

if (!function_exists('storage_exist')) {
    /**
     * Check the existence of file in filesystem
     *
     * @param string|null $filename
     * @return bool|false
     */
    function storage_exist(string $filename = null): bool
    {
        $uploadDisk = env('FILESYSTEM_DISK', 'local');

        return !empty($filename) && Storage::disk($uploadDisk)->exists($filename);
    }

}

/**
 * Check the existence of file in filesystem
 *
 * @param  string|null  $filename
 *
 * @return bool|false
 */

if (!function_exists('current_file_system_disk')) {
    /**
     * Check the existence of file in filesystem
     *
     * @param string|null $filename
     * @return string
     */
    function current_file_system_disk(string $filename = null): string
    {
        return $file_system_disk ?? env('FILESYSTEM_DISK', 'local');
    }

}

// return success response
if (!function_exists('sendSuccessResponse')) {
    function sendSuccessResponse($message, $result, $code=200){
        $resposnse = [
            'status'    => true,
            'code'      => $code,
            'message'   => $message,
            'data'      => $result
        ];
        return response()->json($resposnse, $code);
    }
}

// return errore Response
if (!function_exists('sendErrorResponse')) {
    function sendErrorResponse($errorMessage, $errorData=null, $code=404){

        $resposnse = [
            'status'   => false,
            'code'      => $code,
            'message'   => $errorMessage,
            'data'      => @$errorData
        ];

        return response()->json($resposnse, $code);
    }
}

if (!function_exists('baseUrl')) {
    function baseUrl()
    {
        return url('').'/';
    }
}

if (!function_exists("enTobn")) {

    function enTobn ($input)
    {

        $en =array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, "hour", "day", "week", "month", "year", "ago", "from now","minute");
        $bn = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'ঘন্টা', 'দিন', 'সপ্তাহ', 'মাস', 'বছর','আগে','আগে','মিনিট');
        $convertedDATE = str_replace($en, $bn, $input);
        $convertedDATE = str_replace('s', '', $convertedDATE);

        return "$convertedDATE";

    }

}

if (!function_exists("removeSpecialCharacters")) {
    /**
     * Remove Special Characters
     *
     * @param string $string
     * @return string
     */
    function removeSpecialCharacters(string $string): string
    {
        // Normalize the string (if necessary)
        $string = mb_strtolower($string, 'UTF-8');

        // Replace spaces and special characters with hyphens
        $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', $string);

        // Remove any leading or trailing hyphens
        $slug = trim($slug, '-');

        return $slug;
    }
}

function convertToSlug($string)
{
    // Convert to lowercase
    $string = mb_strtolower($string, 'UTF-8');

    // Replace any character that is not a Unicode letter, number, or hyphen with a space
    $string = preg_replace('/[^\p{L}\p{N}-]+/u', ' ', $string);

    // Replace multiple spaces or hyphens with a single hyphen
    $string = preg_replace('/[\s-]+/', '-', $string);

    // Trim hyphens from the beginning and end of the string
    $string = trim($string, '-');

    return $string;
}


