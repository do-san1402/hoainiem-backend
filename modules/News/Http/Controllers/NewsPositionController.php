<?php

namespace Modules\News\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\News\Http\Requests\NewsPositionUpdateRequest;
use Modules\News\Services\NewsPositionService;

class NewsPositionController extends Controller
{

    public function __construct(
        private NewsPositionService $newsPositionService,
    ) {
        $this->middleware('permission:read_positioning')->only(['index']);
        $this->middleware('permission:update_positioning')->only(['update']);
        $this->middleware('permission:delete_positioning')->only(['destroy']);

        $this->middleware('demo')->only(['update', 'destroy']);

    }

    /**
     * Display a listing of the resource.
     * @param Request
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data = $this->newsPositionService->formData($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => localize_uc("filter_category_successfully"),
                'title'   => localize_uc("filter"),
                'data'    => $data['newsPositions'],
            ]);
        }

        return view('news::position.index', $data);
    }

    /**
     * Update news position
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(NewsPositionUpdateRequest $request): JsonResponse
    {
        $data        = $request->validated();
        $checkUpdate = $this->newsPositionService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("news_position_update_successfully"),
            'title'   => localize("news_position"),
            'data'    => $checkUpdate,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, int $id)
    {
        $this->newsPositionService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("news_position_delete_successfully"),
            'title'   => localize("news_position"),
        ]);
    }

}
