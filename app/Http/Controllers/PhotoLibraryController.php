<?php

namespace App\Http\Controllers;

use App\DataTables\PhotoLibraryDataTable;
use App\Http\Requests\PhotoLibraryRequest;
use App\Services\PhotoLibraryService;
use Illuminate\Http\Request;

class PhotoLibraryController extends Controller
{
    public function __construct(private PhotoLibraryService $photoLibraryService)
    {
        $this->middleware('permission:read_media_library')->only(['index']);
        $this->middleware('permission:create_media_library')->only(['create', 'store']);
        $this->middleware('permission:create_news|update_news|create_post|update_post')->only(['show', 'store']);
        $this->middleware('permission:delete_media_library')->only(['destroy']);

        $this->middleware('demo')->only(['store', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(PhotoLibraryDataTable $dataTable)
    {
        return $dataTable->render('backend.photo-library.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Request $request)
    {
        $data = $this->photoLibraryService->formData($request->all());

        return view('backend.photo-library.create', $data);
    }

    /**
     * Store photo library
     *
     * @param PhotoLibraryRequest $request
     * @return void
     */
    public function store(PhotoLibraryRequest $request)
    {
        $data         = $request->validated();
        $photoLibrary = $this->photoLibraryService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("photo_library_data_delete_successfully"),
            'title'   => localize("photo_library"),
            'data'    => $photoLibrary,
        ]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request)
    {
        $data = $this->photoLibraryService->formData($request->all());

        return view('backend.photo-library.view', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, int $id)
    {
        $this->photoLibraryService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("photo_library_data_delete_successfully"),
            'title'   => localize("photo_library"),
        ]);

    }

}
