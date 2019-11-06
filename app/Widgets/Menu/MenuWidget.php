<?php

namespace App\Widgets\Menu;

use App\Models\Exceptions\MenuException;
use App\Models\Menu;
use App\Services\MenuItem;
use App\Widgets\WidgetInterface;

/**
 * Class MenuWidget
 * @package App\Widgets\Menu
 */
class MenuWidget implements WidgetInterface
{
    /**
     * @var string
     */
    protected $code = null;

    /**
     * @var string ('right' or 'left')
     */
    protected $side = 'right';

    /**
     * @var array
     * @example ['name' => 'Main Menu, 'url' => '/']
     */
    protected $brand = [];

    protected $class = 'navbar-expand-lg navbar-light bg-light';

    /**
     * MenuWidget constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $item) {
            $this->{$key} = $data[$key];
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws MenuException
     */
    public function execute()
    {
        if ($this->code === null) {
            throw new MenuException('', 404);
        }

        $menuModel = Menu::whereCode($this->code)->first();

        if ($menuModel === null) {
            throw new MenuException(trans('menu.menu_not_exist'));
        }

        $menu = MenuItem::getItems($menuModel);
        return view('widgets.menu.index', [
            'menu' => $menu,
            'brand' => [
                'name' => !isset($this->brand['name']) ? $menuModel->name : $this->brand['name'],
                'url' => !isset($this->brand['url']) ? '/' : $this->brand['url']
            ],
            'side' => $this->side,
            'class' => $this->class,
        ]);
    }
}
