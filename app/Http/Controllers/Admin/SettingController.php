<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Setting;
use App\Models\Setting as SettingModel;
use App\Http\Requests\SettingRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Itmaster\Manager\ManagerServiceProvider;

class SettingController extends Controller
{
    /**
     * @var \Illuminate\Support\ServiceProvider|null
     */
    protected $hasModuleRole;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->hasModuleRole = app()->getProvider(ManagerServiceProvider::class);

        if ($this->hasModuleRole) {
            $this->middleware(['permission:setting.index'])->only(['index', 'show']);
            $this->middleware(['permission:setting.create'])->only(['create', 'store']);
            $this->middleware(['permission:setting.update'])->only(['edit', 'update']);
            $this->middleware(['permission:setting.delete'])->only(['destroy']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::getAll();
        return view('admin.setting.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.create', ['setting' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SettingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {
        try {
            Setting::set(
                $request->key,
                is_array($request->value) ? json_encode($request->value) : $request->value,
                $request->title
            );
        } catch (\Exception $e) {
            return redirect()->route('admin.setting.create')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.setting.index');
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
     * @param SettingModel $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(SettingModel $setting)
    {
        return view('admin.setting.edit', ['setting' => $setting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SettingRequest $request
     * @param SettingModel $setting
     * @return Response
     */
    public function update(SettingRequest $request, SettingModel $setting)
    {
        try {
            Setting::set(
                $setting->key,
                is_array($request->value) ? json_encode($request->value) : $request->value,
                $request->title,
                $setting->active,
                $setting->groups,
                $setting->type
            );
        } catch (\Exception $e) {
            return redirect()->route('admin.setting.edit', $setting)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.setting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
