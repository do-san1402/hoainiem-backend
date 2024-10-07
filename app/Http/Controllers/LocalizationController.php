<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LocalizationController extends Controller
{
    public function index()
    {
        $langValue = app_setting()->lang?->value;
        $langFile = base_path('lang/'.$langValue.'/language.php');
        if (! file_exists($langFile)) {
            File::put($langFile, '<?php return array();');
        }
        $strings = File::getRequire($langFile);

        return response()->json($strings);
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);
        $langValue = app_setting()->lang?->value;
        $langFile = base_path('lang/'.$langValue.'/language.php');
        if (! file_exists($langFile)) {
            File::put($langFile, '<?php return array();');
        }

        $strings = File::getRequire($langFile);
        // push new item to strings
        $strings[$request->key] = $request->value;
        // put to the file
        File::put($langFile, '<?php return '.var_export($strings, true).';');

        return response()->json(['message' => 'Successfully added new key to language file.', 'data' => $strings, 'status' => 200]);

    }
}
