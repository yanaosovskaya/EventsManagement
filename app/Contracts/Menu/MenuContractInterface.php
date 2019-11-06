<?php

namespace App\Contracts\Menu;

use App\Http\Requests\Menu\MenuRequest;
use App\Models\Exceptions\MenuException;
use App\Models\Menu;
use Illuminate\Support\Collection;

/**
 * Interface MenuContractInterface
 * @package App\Contracts\Menu
 */
interface MenuContractInterface
{
    /**
     * @return Collection
     */
    public function get();

    /**
     * @param int $page
     * @return Collection/\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($page = 10);

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findById($id);

    /**
     * @param MenuRequest $request
     * @param Menu $menu
     * @return mixed
     * @throws MenuException
     */
    public function update(MenuRequest $request, Menu $menu);

    /**
     * @param Menu $menu
     * @return bool
     * @throws \Exception
     */
    public function delete(Menu $menu);
}
