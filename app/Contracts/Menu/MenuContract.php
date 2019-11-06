<?php

namespace App\Contracts\Menu;

use App\Http\Requests\Menu\MenuRequest;
use App\Models\Exceptions\MenuException;
use App\Models\Menu;
use Illuminate\Support\Collection;

/**
 * Class MenuContract
 * @package App\Contracts\Menu
 */
class MenuContract implements MenuContractInterface
{
    /**
     * @var Menu
     */
    protected $model;

    /**
     * MenuContract constructor.
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    /**
     * @return Collection
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * @param int $page
     * @return Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($page = 10)
    {
        return $this->model->paginate($page);
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param MenuRequest $request
     * @param Menu $menu
     * @return mixed
     * @throws MenuException
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        try {
            $menu->fill($request->all());
            if (!$menu->save()) {
                throw new MenuException('Menu not saved.');
            }
        } catch (\Exception $e) {
            throw new MenuException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param Menu $menu
     * @return bool
     * @throws \Exception
     */
    public function delete(Menu $menu)
    {
        return $menu->delete();
    }
}
