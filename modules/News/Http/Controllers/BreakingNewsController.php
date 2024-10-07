<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\DataTables\BreakingNewsDataTable;
use Modules\News\Http\Requests\BreakingNewsRequest;
use Modules\News\Services\BreakingNewsService;

class BreakingNewsController extends Controller
{

    public function __construct(
        private BreakingNewsService $breakingNewsService,
    ) {
        $this->middleware('permission:read_breaking_news')->only(['index']);
        $this->middleware('permission:create_breaking_news')->only(['store']);
        $this->middleware('permission:update_breaking_news')->only(['edit', 'update']);
        $this->middleware('permission:delete_breaking_news')->only(['destroy']);

        $this->middleware('demo')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @param BreakingNewsDataTable
     * @return Renderable
     */
    public function index(BreakingNewsDataTable $dataTable)
    {
        $data = $this->breakingNewsService->formData();

        return $dataTable->render('news::breaking-news.index', $data);
    }


    /**
     * store
     *
     * @param BreakingNewsRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(BreakingNewsRequest $request): JsonResponse
    {
        $data         = $request->validated();
        $breakingNews = $this->breakingNewsService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("breaking_news_create_successfully"),
            'title'   => localize("breaking_news"),
            'data'    => $breakingNews,
        ]);
    }


    /**
     * Show edit
     *
     * @param  int  $breakingNewsId
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(int $breakingNewsId): JsonResponse
    {
        $breakingNews = $this->breakingNewsService->edit(['id' => $breakingNewsId]);

        return response()->json([
            'success' => true,
            'message' => localize("breaking_news_data_found_successfully"),
            'title'   => localize("breaking_news"),
            'data'    => $breakingNews,
        ]);
    }

    /**
     * Update
     *
     * @param BreakingNewsRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(BreakingNewsRequest $request, int $breakingNewsId): JsonResponse
    {
        $data         = $request->validated();
        $data['id']   = $breakingNewsId;
        $breakingNews = $this->breakingNewsService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("breaking_news_update_successfully"),
            'title'   => localize("breaking_news"),
            'data'    => $breakingNews,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, int $id)
    {
        $this->breakingNewsService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("breaking_news_delete_successfully"),
            'title'   => localize("breaking_news"),
        ]);
    }

}
