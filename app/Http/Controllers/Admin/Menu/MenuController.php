<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Contracts\Menu\MenuContractInterface;
use App\Http\Requests\Menu\MenuRequest;
use App\Models\Exceptions\MenuException;
use App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Services\MenuItem;
use Itmaster\Manager\ManagerServiceProvider;
use Itmaster\Page\Models\Page;
use Itmaster\Page\PageServiceProvider;

/**
 * Class MenuController
 * @package App\Http\Controllers\Admin
 */
class MenuController extends Controller
{
    /**
     * @var \Illuminate\Support\ServiceProvider|null
     */
    protected $hasModuleRole;

    /**
     * @var \Illuminate\Support\ServiceProvider|null
     */
    protected $hasModulePage;

    /**
     * @var MenuContractInterface
     */
    protected $menuContract;

    /**
     * UserController constructor.
     * @param MenuContractInterface $menuContract
     */
    public function __construct(MenuContractInterface $menuContract)
    {
        $this->menuContract = $menuContract;

        $this->hasModuleRole = app()->getProvider(ManagerServiceProvider::class);
        $this->hasModulePage = app()->getProvider(PageServiceProvider::class);

        if ($this->hasModuleRole) {
            $this->middleware(['permission:menu.index'])->only(['index', 'show']);
            $this->middleware(['permission:menu.update'])->only(['edit', 'update']);
            $this->middleware(['permission:menu.create'])->only(['create', 'store']);
            $this->middleware(['permission:menu.delete'])->only(['destroy']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = $this->menuContract->paginate();
        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menu.create', ['menu' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MenuRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        try {
            $menu = new Menu();
            $this->menuContract->update($request, $menu);
        } catch (MenuException $e) {
            return redirect()->route('admin.menu.create')
                ->with('error', $e->getMessage());
        }

        if (\Permission::hasAnyPermission('menu.update')) {
            return redirect()->route('admin.menu.edit', $menu);
        }

        return redirect()->route('admin.menu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $items = $menu->items;

        $tree = MenuItem::getTree($menu);

        $pages = $this->hasModulePage ? Page::all() : [];

        return view('admin.menu.edit', compact('menu', 'items', 'tree', 'pages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MenuRequest $request
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        try {
            $this->menuContract->update($request, $menu);
        } catch (MenuException $e) {
            return redirect()->route('admin.menu.edit', $menu)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu $menu
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
        $this->menuContract->delete($menu);
        return redirect()->route('admin.menu.index');
    }
}
