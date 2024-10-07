<?php

namespace Modules\Menu\Http\Controllers;

use App\Http\Requests\UpdateStatusRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Menu\DataTables\MenuDataTable;
use Modules\Menu\Services\MenuService;

class MenuController extends Controller
{
    public function __construct(
        private MenuService $menuService,
    ) {
        $this->middleware('permission:read_menu_setup')->only(['index']);
        $this->middleware('permission:update_menu_setup')->only(['updateStatus']);

        $this->middleware('demo')->only(['updateStatus']);
    }

    /**
     * Display a listing of the resource.
     * @param MenuDataTable $dataTable
     * @return Renderable
     */
    public function index(MenuDataTable $dataTable)
    {
        return $dataTable->render('menu::index');
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
        $data            = $request->validated();
        $data['menu_id'] = $id;
        $status_span     = $this->menuService->updateStatus($data);

        return response()->json([
            'success' => true,
            'message' => localize("menu_update_status_successfully"),
            'title'   => localize("menu"),
            'data'    => $status_span,
        ]);
    }

}
