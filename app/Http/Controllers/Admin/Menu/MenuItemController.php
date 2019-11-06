<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Requests\Menu\MenuItemRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\MenuItem as MenuItemService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  MenuItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuItemRequest $request)
    {
        try {
            $menuItem = new MenuItem();
            $menuItem = MenuItemService::update($menuItem, $request);

        } catch (\Exception $e) {
            return response($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }

        return response($menuItem->toJson(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function showTree(Menu $menu)
    {
        $tree = MenuItemService::getTree($menu);
        return response(compact('tree'), 200);
    }

    /**
     * @param Request $request
     * @param MenuItem $menuItem
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateSorting(Request $request, MenuItem $menuItem)
    {
        $this->validate($request, [
            'sort' => [
                'required',
                'integer',
                Rule::in([1, 0])
            ],
        ]);

        try {
            $menuItem = MenuItemService::updateSorting($menuItem, $request);

        } catch (\Exception $e) {
            return response($e->getMessage(), is_numeric($e->getCode()) ? $e->getCode() : 500);
        }

        return response($menuItem->toJson(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MenuItem $menuItem
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return response('', 200);
    }
}
