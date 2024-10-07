<?php

namespace Modules\Menu\Services;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;
use Modules\Menu\Entities\Link;
use Modules\Menu\Entities\MenuContent;
use Modules\Page\Entities\Page;

class MenuSetupService
{
    /**
     * Form Data
     *
     * @param int $menuId
     * @return array
     */
    public function formData(int $menuId): array
    {
        $menuContents     = MenuContent::where('menu_id', $menuId)->orderBy('menu_position', 'ASC')->get();
        $menuContentSlugs = $menuContents->whereNotNull('slug')->pluck('slug')->toArray();

        $categories = Category::whereNotIn('slug', $menuContentSlugs)->get();
        $pages      = Page::get();
        $links      = Link::get();
        return compact('menuContents', 'categories', 'pages', 'links');
    }

    /**
     * Update Menu Content
     *
     * @param  array  $attributes
     * @return MenuContent
     * @throws Exception
     */
    public function updateMenuContent(array $attributes): MenuContent
    {
        $menuId        = $attributes['menu_id'];
        $menuContentId = $attributes['menu_content_id'];

        try {
            DB::beginTransaction();

            $menuContentData = [
                'menu_level'    => $attributes['level'],
                'menu_position' => $attributes['position'] ?? null,
                'link_url'      => $attributes['link'] ?? null,
                'parent_id'     => $attributes['parent_id'] ?? null,
            ];

            MenuContent::find($menuContentId)->update($menuContentData);

            $menuContent = MenuContent::find($menuContentId);

            DB::commit();

            return $menuContent;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("menu_content_update_error"),
                'title'   => localize("menu_content"),
            ], 422));
        }

    }

    /**
     * Delete Menu Content
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroyMenuContent(array $attributes): bool
    {
        $menuId        = $attributes['menu_id'];
        $menuContentId = $attributes['menu_content_id'];

        try {
            DB::beginTransaction();

            MenuContent::where(['id' => $menuContentId, 'menu_id' => $menuId])->delete();

            DB::commit();

            return true;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("menu_content_delete_error"),
                'title'   => localize("menu_content"),
            ], 422));
        }

    }

    /**
     * Update Position Menu Content
     *
     * @param  array  $attributes
     * @return MenuContent
     * @throws Exception
     */
    public function updatePositionMenuContent(array $attributes): bool
    {
        $menuId = $attributes['menu_id'];
        $ids    = $attributes['id'];

        try {
            DB::beginTransaction();

            foreach ($ids as $key => $id) {
                $position = $key + 1;
                MenuContent::where(['id' => $id, 'menu_id' => $menuId])->update(['menu_position' => $position]);
            }

            DB::commit();

            return true;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("menu_content_position_update_error"),
                'title'   => localize("menu_content"),
            ], 422));
        }

    }

    /**
     * Create Category Menu Content
     *
     * @param  array  $attributes
     * @return MenuContent
     * @throws Exception
     */
    public function createCategoryMenuContent(array $attributes): bool
    {
        $menuId      = $attributes['menu_id'];
        $contentType = $attributes['content_type'];
        $contentsId  = $attributes['content_id'];
        try {
            DB::beginTransaction();

            foreach ($contentsId as $contentId) {

                $category = Category::findOrFail($contentId);

                $menuContentData = [
                    'content_type' => $contentType,
                    'content_id'   => $category->category_id,
                    'slug'         => $category->slug,
                    'menu_level'   => $category->category_name,
                    'menu_id'      => $menuId,
                ];

                MenuContent::create($menuContentData);
            }

            DB::commit();

            return true;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("category_menu_content_create_error"),
                'title'   => localize("category_menu_content"),
            ], 422));
        }

    }

    /**
     * Create Page Menu Content
     *
     * @param  array  $attributes
     * @return MenuContent
     * @throws Exception
     */
    public function createPageMenuContent(array $attributes): bool
    {
        $menuId      = $attributes['menu_id'];
        $contentType = $attributes['content_type'];
        $contentsId  = $attributes['content_id'];
        try {
            DB::beginTransaction();

            foreach ($contentsId as $contentId) {

                $page = Page::findOrFail($contentId);

                $menuContentData = [
                    'content_type' => $contentType,
                    'content_id'   => $page->page_id,
                    'slug'         => $page->page_slug,
                    'menu_level'   => $page->title,
                    'menu_id'      => $menuId,
                ];

                MenuContent::create($menuContentData);
            }

            DB::commit();

            return true;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("category_menu_content_create_error"),
                'title'   => localize("category_menu_content"),
            ], 422));
        }

    }

    /**
     * Create Link Menu Content
     *
     * @param  array  $attributes
     * @return MenuContent
     * @throws Exception
     */
    public function createLinkMenuContent(array $attributes): bool
    {
        $menuId     = $attributes['menu_id'];
        $contentsId = $attributes['content_id'];
        try {
            DB::beginTransaction();

            foreach ($contentsId as $contentId) {
                $link = Link::findOrFail($contentId);

                $menuContentData = [
                    'content_type' => 'links',
                    'link_url'     => $link->url,
                    'menu_level'   => $link->level,
                    'menu_id'      => $menuId,
                ];

                MenuContent::create($menuContentData);
            }

            DB::commit();

            return true;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("link_menu_content_create_error"),
                'title'   => localize("link_menu_content"),
            ], 422));
        }

    }

    /**
     * Create Link and Menu Content
     *
     * @param  array  $attributes
     * @return array
     * @throws Exception
     */
    public function createLink(array $attributes): array
    {
        try {
            DB::beginTransaction();

            $linkData = [
                'level' => $attributes['level'],
                'link'  => $attributes['link'],
            ];

            $link = Link::create($linkData);

            $menuContentData = [
                'menu_level'    => $attributes['level'],
                'content_type'  => 'links',
                'content_id'    => $link->id,
                'menu_position' => $attributes['position'] ?? null,
                'menu_id'       => $attributes['menu_id'],
                'link_url'      => $attributes['link'] ?? null,
                'parent_id'     => $attributes['parent_id'] ?? null,
            ];

            $menuContent = MenuContent::create($menuContentData);

            DB::commit();

            return ['link' => $link, 'menu_content' => $menuContent];
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("link_create_error"),
                'title'   => localize("link"),
            ], 422));
        }

    }

}
