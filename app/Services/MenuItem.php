<?php

namespace App\Services;

use App\Http\Requests\Menu\MenuItemRequest;
use App\Models\Exceptions\MenuException;
use App\Models\Menu;
use \App\Models\MenuItem as MenuItemModel;
use Illuminate\Http\Request;

/**
 * Class MenuItem
 * @package App\Services
 */
class MenuItem
{
    /**
     * @param MenuItemModel $menuItem
     * @param MenuItemRequest $request
     * @return MenuItemModel
     * @throws MenuException
     */
    public static function update(MenuItemModel $menuItem, MenuItemRequest $request)
    {
        $menuItem->fill($request->all());

        $maxSorting = MenuItemModel::where('parent_id', $menuItem->parent_id)
            ->where('menu_id', $menuItem->menu_id)
            ->max('sorting');

        $menuItem->sorting = empty($maxSorting) ? 1 : ($maxSorting + 1);

        if (!$menuItem->save()) {
            throw new MenuException('Menu Item not saved.');
        }

        return $menuItem;
    }

    /**
     * @param MenuItemModel $menuItem
     * @param Request $request
     * @return MenuItemModel
     * @throws MenuException
     */
    public static function updateSorting(MenuItemModel $menuItem, Request $request)
    {
        $sortingIndex = $request->sort ? ($menuItem->sorting - 1) : ($menuItem->sorting + 1);
        $item = MenuItemModel::where('parent_id', $menuItem->parent_id)
            ->where('menu_id', $menuItem->menu_id)
            ->where('sorting', $sortingIndex)
            ->orderBy('sorting', $request->sort ? SORT_DESC : SORT_ASC)
            ->first();

        if ($item !== null) {
            $item->sorting = $menuItem->sorting;
            if (!$item->save()) {
                throw new MenuException('Error sorting1');
            }
        }

        $menuItem->sorting = $sortingIndex;
        if (!$menuItem->save()) {
            throw new MenuException('Error sorting2');
        }

        return $menuItem;
    }

    /**
     * @param Menu $menu
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getItems(Menu $menu)
    {
        $items = $menu->items()
            ->where('parent_id', null)
            ->orderBy('sorting')
            ->get();

        $filtered = $items->reject(function (\App\Models\MenuItem $value) {
            if ($value->type === \App\Models\MenuItem::TYPE_PAGE) {
                return !$value->page;
            }
        });

        return $filtered;
    }

    /**
     * @param Menu $menu
     * @return array
     */
    public static function getTree(Menu $menu)
    {
        $items = self::getItems($menu);

        $nodes = [];
        foreach ($items as $item) {
            $nodes[] = self::modelToResource($item);
        }

        return $nodes;
    }

    /**
     * @param MenuItemModel $menuItem
     * @return array
     */
    private static function getNode(MenuItemModel $menuItem)
    {
        $children = $menuItem->children()->orderBy('sorting')->get();

        $nodes = [];
        foreach ($children as $item) {
            $nodes[] = self::modelToResource($item);
        }

        return $nodes;
    }

    /**
     * @param MenuItemModel $item
     * @return array
     */
    private static function modelToResource(MenuItemModel $item)
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => MenuItemModel::getType($item->type),
            'visible' => MenuItemModel::getVisibilityStatus($item->visible),
            'sorting' => $item->sorting,
            'nodes' => self::getNode($item)
        ];
    }

    /**
     * @param $value
     * @param array $args
     * @return false|string
     * @throws \Exception
     */
    public static function bladeCompile($value, array $args = array())
    {
        $generated = \Blade::compileString($value);

        ob_start() and extract($args, EXTR_SKIP);

        try {
            eval('?>' . $generated);
        } catch (\Exception $e) {
            ob_get_clean();
            throw $e;
        }

        $content = ob_get_clean();

        return $content;
    }
}
