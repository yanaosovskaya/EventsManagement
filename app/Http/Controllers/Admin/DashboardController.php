<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Itmaster\Manager\ManagerServiceProvider;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
    /**
     * @var \Illuminate\Support\ServiceProvider|null
     */
    protected $hasModuleRole;

    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->hasModuleRole = app()->getProvider(ManagerServiceProvider::class);
        if ($this->hasModuleRole) {
            $this->middleware(['permission:admin.panel']);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
