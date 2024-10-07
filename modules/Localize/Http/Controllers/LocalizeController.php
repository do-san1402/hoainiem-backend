<?php

namespace Modules\Localize\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Modules\Localize\Entities\Langstring;
use Modules\Localize\Entities\Langstrval;
use Modules\Localize\Entities\Language;

class LocalizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('localize::index');
    }

    /**
     * Display a listing of the resource.
     */
    public function languagelist()
    {
        $langList_DB  = DB::table('lang')->where('id', '<>', 1)->get();
        $languageList = Language::paginate(10);

        return view('localize::language_list', compact('langList_DB', 'languageList'));
    }

    /**
     * Display a listing of the resource.
     */
    public function languageStringValueindex(Language $localize)
    {
        $langstringValues = Langstrval::where('localize_id', $localize->id)->latest()->paginate(10);
        $langName         = $localize->langname;
        $lanfolder        = $localize->value;

        return view('localize::langstrvalue', compact('langstringValues', 'lanfolder', 'langName'));
    }

    /**
     * Display a listing of the resource.
     */
    public function lanstrvaluestore(Request $request)
    {
        $lanstrvalue   = $request->lanstrvalue;
        $lanstrvalueid = $request->lanstrvalueid;
        $localizeid    = $request->localizeid;
        $langstringid  = $request->langstringid;

        $arrayUpdate = [];
        foreach ($lanstrvalue as $key => $lanvalue) {
            $arrayUpdate[$key] = [
                'id'            => $lanstrvalueid[$key],
                'value'         => $lanvalue,
                'localize_id'   => $localizeid[$key],
                'langstring_id' => $langstringid[$key],
            ];
        }

        Langstrval::upsert(
            $arrayUpdate,
            ['id', 'localize_id', 'langstring_id'],
            ['value']
        );

        $languageId = $localizeid[0];

        $languageFileWritedContent = $this->writeLangFile($languageId);

        $writePath = lang_path($request->lanfolder . '/language.php');
        File::put($writePath, $languageFileWritedContent);

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     */
    public function languageStringList()
    {
        $languageStringList = Langstring::latest()->paginate(10);

        return view('localize::language_string_list', compact('languageStringList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('localize::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function languageStore(Request $request)
    {
        $request->validate([
            'langname' => 'unique:languages|required',
        ]);

        $data = [
            'langname' => $request->langname,
            'value'    => $request->value,
        ];

        $path = lang_path($request->value);
        if (File::isDirectory($path)) {
        }
        else {

            File::makeDirectory($path, 0777, true, true);
            $targetFileLocation = lang_path($request->value . '/language.php');
            $makeCopyFile       = lang_path('en/language.php');
            File::copy($makeCopyFile, $targetFileLocation);
        }

        $localize_value     = Language::create($data);
        $localize_id        = $localize_value->id;
        $languageStringList = Langstring::all();
        $currentTime        = Carbon::now();

        $arrayUpdate = [];
        foreach ($languageStringList as $key => $lanvalue) {
            $arrayUpdate[$key] = [
                'localize_id'   => $localize_id,
                'langstring_id' => $lanvalue->id,
                'created_at'    => $currentTime,
                'updated_at'    => $currentTime,
            ];
        }
        Langstrval::insert($arrayUpdate);

        return redirect()->back()->with('success', localize('data_save'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storelanstring(Request $request)
    {
        $request->validate([
            'key' => 'unique:langstrings|required',
        ]);

        $getdata = $request->key;

        $getdata = preg_replace('/[^A-Za-z0-9\-]/', ' ', $getdata);
        $getdata = preg_replace('/[\/\&%#\$]/', ' ', $getdata);
        $getdata = str_replace(' ', '_', $getdata);
        $getdata = strtolower($getdata);

        $data = [
            'key' => $getdata,
        ];

        $currentTime  = Carbon::now();
        $langstringid = Langstring::create($data);

        $languagelist = Language::all();

        $inserData = [];
        foreach ($languagelist as $key => $value) {
            $inserData[$key] = [
                'localize_id'   => $value->id,
                'langstring_id' => $langstringid->id,
                'created_at'    => $currentTime,
                'updated_at'    => $currentTime,
            ];
        }
        Langstrval::insert($inserData);

        return redirect()->back()->with('success', localize('data_save'));
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return view('localize::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        return view('localize::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function languageStringDestroy($id)
    {
        Langstring::where('id', $id)->delete();
        Toastr::success('Deleted Successfully..!!', 'Success');

        return response()->json(['success' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function languageDestroy($id)
    {
        Language::where('id', $id)->delete();
        Toastr::success('Deleted Successfully..!!', 'Success');

        return response()->json(['success' => 'success']);
    }

    public function writeLangFile($languageId)
    {
        $langSubStrDetail = Langstrval::where('localize_id', $languageId)->get();

        $indicator = '=>';

        $langContent = '<?php';
        $langContent .= "\n";
        $langContent .= 'return [';
        $langContent .= "\n";
        foreach ($langSubStrDetail as $key => $langvalud) {
            $kye         = $langvalud->langstring->key;
            $langContent .= "'$kye'";
            $langContent .= $indicator;
            $langContent .= "'$langvalud->value'";
            $langContent .= ',';
            $langContent .= "\n";
        }

        $langContent .= '];';
        $langContent .= "\n";
        $langContent .= '?>';

        return $langContent;
    }

    public function switchLang($lang)
    {
        Session::put('applocale', $lang);
        Toastr::success('Language Save Successfully', 'Success');

        return redirect()->back();
    }
}
