<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\DataTables\NewsPostDataTable;
use Modules\News\Http\Requests\NewsPostRequest;
use Modules\News\Services\NewsPostService;
use Modules\News\Services\ReporterService;

class NewsPostController extends Controller
{

    public function __construct(
        private NewsPostService $newsPostService,
        private ReporterService $reporterService
    ) {
        $this->middleware('permission:read_post')->only(['index']);
        $this->middleware('permission:create_post')->only(['create', 'store']);
        $this->middleware('permission:update_post')->only(['edit', 'update']);
        $this->middleware('permission:delete_post')->only(['destroy']);

        $this->middleware('demo')->only(['store', 'update', 'destroy']);
    }

    /**
     * Index
     *
     * @return Renderable
     */
    public function index(NewsPostDataTable $dataTable)
    {
        return $dataTable->render('news::post.index');
    }

    /**
     * Create
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
        $data = $this->newsPostService->formData();

        return view('news::post.create', $data);
    }

    /**
     * Store
     *
     * @param NewsPostRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(NewsPostRequest $request): JsonResponse
    {
        $data = $request->validated();

        $newsPost = $this->newsPostService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("photo_post_create_successfully"),
            'title'   => localize("photo_post"),
            'data'    => $newsPost,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $data              = $this->newsPostService->formData();
        $data['photoPost'] = $this->newsPostService->photoPostData($id);

        return view('news::post.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsPostRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(NewsPostRequest $request, int $id): JsonResponse
    {
        $data                  = $request->validated();
        $data['photo_post_id'] = $id;
        $news                  = $this->newsPostService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("photo_post_update_successfully"),
            'title'   => localize("photo_post"),
            'data'    => $news,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->newsPostService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("photo_post_data_delete_successfully"),
            'title'   => localize("photo_post"),
        ]);
    }

}
