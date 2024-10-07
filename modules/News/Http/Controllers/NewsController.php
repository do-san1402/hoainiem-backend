<?php

namespace Modules\News\Http\Controllers;

use App\Http\Requests\UpdateStatusRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\DataTables\NewsDataTable;
use Modules\News\Http\Requests\NewsRequest;
use Modules\News\Http\Requests\ReporterRequest;
use Modules\News\Services\NewsService;
use Modules\News\Services\ReporterService;

class NewsController extends Controller
{

    public function __construct(
        private NewsService $newsService,
        private ReporterService $reporterService,
    ) {
        $this->middleware('permission:read_news')->only(['index', 'show']);
        $this->middleware('permission:create_news')->only(['create', 'store']);
        $this->middleware('permission:update_news')->only(['edit', 'update', 'updateStatus']);
        $this->middleware(['permission:delete_news'])->only(['destroy']);
        $this->middleware('permission:create_news|update_news')->only(['storeReport']);

        $this->middleware(['demo'])->only(['store', 'updateStatus', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(NewsDataTable $dataTable)
    {
        $data = $this->newsService->filterData();

        return $dataTable->render('news::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = $this->newsService->formData();
        return view('news::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(NewsRequest $request): JsonResponse
    {
        $data = $request->validated();

        $news = $this->newsService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("news_create_successfully"),
            'title'   => localize("news"),
            'data'    => $news,
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('news::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(int $id)
    {
        $data            = $this->newsService->formData();
        $data['newsMst'] = $this->newsService->newsMstData($id);

        return view('news::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(NewsRequest $request, int $id): JsonResponse
    {
        $data                = $request->validated();
        $data['news_mst_id'] = $id;
        $news                = $this->newsService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("news_update_successfully"),
            'title'   => localize("news"),
            'data'    => $news,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, int $id)
    {
        $this->newsService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("news_data_delete_successfully"),
            'title'   => localize("news"),
        ]);
    }

    /**
     * Store Report
     *
     * @param ReporterRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function storeReport(ReporterRequest $request)
    {
        $data     = $request->validated();
        $reporter = $this->reporterService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize_uc("reporter_created_successfully"),
            'title'   => localize_uc("reporter"),
            'data'    => $reporter,
        ]);
    }

    /**
     * Update status
     *
     * @param UpdateStatusRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function updateStatus(UpdateStatusRequest $request, int $id): JsonResponse
    {
        $data                = $request->validated();
        $data['news_mst_id'] = $id;
        $status_span         = $this->newsService->updateStatus($data);

        return response()->json([
            'success' => true,
            'message' => localize("news_update_status_successfully"),
            'title'   => localize("news"),
            'data'    => $status_span,
        ]);
    }

}
