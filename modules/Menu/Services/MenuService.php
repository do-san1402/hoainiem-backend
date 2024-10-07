<?php

namespace Modules\Menu\Services;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Menu\Entities\Menu;

class MenuService
{

    /**
     * Update Menu Status
     *
     * @param  array  $attributes
     * @return string
     * @throws Exception
     */
    public function updateStatus(array $attributes): string
    {
        $menuId = $attributes['menu_id'];
        $menu   = Menu::findOrFail($menuId);

        try {
            DB::beginTransaction();

            $status = $attributes['status'] ?? 0;

            $menuData = [
                'status' => $status,
            ];

            $menu->update($menuData);
            $menu->refresh();

            DB::commit();

            $status_span = "";

            if ($menu->status == 1) {
                $status_span = '<span class="btn btn-labeled btn-success mb-2 mr-1 update-status-button" title="' . localize('publish') . '" data-action="' . route('menu.update-status', ['menu' => $menu->id]) . '" data-update_status="0" >' . localize('publish') . '</span>';

            } else {
                $status_span = '<span class="btn btn-labeled btn-warning mb-2 mr-1 update-status-button" title="' . localize('unpublish') . '" data-action="' . route('menu.update-status', ['menu' => $menu->id]) . '" data-update_status="1" >' . localize('unpublish') . '</span>';

            }

            return $status_span;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("menu_update_status_error"),
                'title'   => localize("menu"),
            ], 422));
        }

    }

}
