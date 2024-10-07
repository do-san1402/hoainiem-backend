<?php

namespace Modules\Menu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\MenuContent;
use Modules\Menu\Http\Requests\CategoryMenuContentRequest;
use Modules\Menu\Http\Requests\LinkMenuContentRequest;
use Modules\Menu\Http\Requests\LinkRequest;
use Modules\Menu\Http\Requests\PageMenuContentRequest;
use Modules\Menu\Http\Requests\UpdateMenuContentRequest;
use Modules\Menu\Http\Requests\UpdatePositionMenuContentRequest;
use Modules\Menu\Services\MenuSetupService;

class MenuSetupController extends Controller
{
    public function __construct(
        private MenuSetupService $menuSetupService,
    ) {
        $this->middleware('demo')->only(['storeCategoryMenuContent', 'storePageMenuContent', 'storeLinkMenuContent', 'storeLink', 'update', 'updatePosition', 'destroy']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $menuId
     * @return Renderable
     */
    public function create(int $menuId): View
    {
        $data            = $this->menuSetupService->formData($menuId);
        $data['menu_id'] = $menuId;
        return view('menu::setup.create', $data);
    }

    /**
     * Edit Menu Content in storage.
     *
     * @param Request $request
     * @param int $menuId
     * @param int $menuContentId
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(Request $request, int $menuId, int $menuContentId): JsonResponse
    {
        $menu = Menu::find($menuId);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => localize("update_error"),
                'title'   => localize("invalid_data"),
            ], 422);
        }

        $menuContent = MenuContent::where(['menu_id' => $menuId, 'id' => $menuContentId])->first();

        return response()->json([
            'success' => true,
            'message' => localize("menu_content_data_successfully"),
            'title'   => localize("menu_content"),
            'data'    => $menuContent,
        ]);
    }

    /**
     * Update Menu Content in storage.
     * @param UpdateMenuContentRequest $request
     * @param int $menuId
     * @return JsonResponse
     * @throws Exception
     */
    public function update(UpdateMenuContentRequest $request, int $menuId, int $menuContentId): JsonResponse
    {
        $menu = Menu::find($menuId);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => localize("update_error"),
                'title'   => localize("invalid_data"),
            ], 422);
        }

        $data                    = $request->validated();
        $data['menu_id']         = $menuId;
        $data['menu_content_id'] = $menuContentId;

        if($menuContentId == $data['parent_id']){
            return response()->json([
                'success' => false,
                'message' => localize("update_error"),
                'title'   => localize("menu_content_and_parent_are_same"),
            ], 422);
        }

        $menuContent = $this->menuSetupService->updateMenuContent($data);

        return response()->json([
            'success' => true,
            'message' => localize("menu_content_position_update_successfully"),
            'title'   => localize("menu_content"),
            'data'    => $menuContent,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $menuId, int $menuContentId):JsonResponse
    {
        $this->menuSetupService->destroyMenuContent(['menu_id'=> $menuId, 'menu_content_id' => $menuContentId]);

        return response()->json([
            'success' => true,
            'message' => localize("menu_content_delete_successfully"),
            'title'   => localize("menu_content"),
        ]);
    }

    /**
     * Update Position Menu Content in storage.
     * @param UpdatePositionMenuContentRequest $request
     * @param int $menuId
     * @return JsonResponse
     * @throws Exception
     */
    public function updatePosition(UpdatePositionMenuContentRequest $request, int $menuId): JsonResponse
    {
        $menu = Menu::find($menuId);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => localize("update_error"),
                'title'   => localize("invalid_data"),
            ], 422);
        }

        $data            = $request->validated();
        $data['menu_id'] = $menuId;

        $checkUpdate = $this->menuSetupService->updatePositionMenuContent($data);

        return response()->json([
            'success' => true,
            'message' => localize("menu_content_position_update_successfully"),
            'title'   => localize("menu_content"),
            'data'    => $checkUpdate,
        ]);
    }

    /**
     * Store Category Menu Content in storage.
     * @param CategoryMenuContentRequest $request
     * @param int $menuId
     * @return JsonResponse
     * @throws Exception
     */
    public function storeCategoryMenuContent(CategoryMenuContentRequest $request, int $menuId): JsonResponse
    {
        $menu = Menu::find($menuId);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => localize("create_error"),
                'title'   => localize("invalid_data"),
            ], 422);
        }

        $data            = $request->validated();
        $data['menu_id'] = $menuId;

        $categoryMenuContent = $this->menuSetupService->createCategoryMenuContent($data);

        return response()->json([
            'success' => true,
            'message' => localize("category_menu_content_create_successfully"),
            'title'   => localize("category_menu_content"),
            'data'    => $categoryMenuContent,
        ]);
    }

    /**
     * Store Page Menu Content in storage.
     * @param PageMenuContentRequest $request
     * @param int $menuId
     * @return JsonResponse
     * @throws Exception
     */
    public function storePageMenuContent(PageMenuContentRequest $request, int $menuId): JsonResponse
    {
        $menu = Menu::find($menuId);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => localize("create_error"),
                'title'   => localize("invalid_data"),
            ], 422);
        }

        $data            = $request->validated();
        $data['menu_id'] = $menuId;

        $pageMenuContent = $this->menuSetupService->createPageMenuContent($data);

        return response()->json([
            'success' => true,
            'message' => localize("page_menu_content_create_successfully"),
            'title'   => localize("page_menu_content"),
            'data'    => $pageMenuContent,
        ]);
    }

    /**
     * Store Link Menu Content in storage.
     * @param LinkMenuContentRequest $request
     * @param int $menuId
     * @return JsonResponse
     * @throws Exception
     */
    public function storeLinkMenuContent(LinkMenuContentRequest $request, int $menuId): JsonResponse
    {
        $menu = Menu::find($menuId);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => localize("create_error"),
                'title'   => localize("invalid_data"),
            ], 422);
        }

        $data            = $request->validated();
        $data['menu_id'] = $menuId;

        $linkMenuContent = $this->menuSetupService->createLinkMenuContent($data);

        return response()->json([
            'success' => true,
            'message' => localize("link_menu_content_create_successfully"),
            'title'   => localize("link_menu_content"),
            'data'    => $linkMenuContent,
        ]);
    }

    /**
     * Store Link in storage.
     * @param LinkRequest $request
     * @param int $menuId
     * @return JsonResponse
     * @throws Exception
     */
    public function storeLink(LinkRequest $request, int $menuId): JsonResponse
    {
        $menu = Menu::find($menuId);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => localize("create_error"),
                'title'   => localize("invalid_data"),
            ], 422);
        }

        $data            = $request->validated();
        $data['menu_id'] = $menuId;

        $menuContent = $this->menuSetupService->createLink($data);

        return response()->json([
            'success' => true,
            'message' => localize("link_create_successfully"),
            'title'   => localize("link"),
            'data'    => $menuContent,
        ]);
    }

}
