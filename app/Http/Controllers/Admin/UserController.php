<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Itmaster\Manager\ManagerServiceProvider;
use Itmaster\Manager\Models\Permission;
use Itmaster\Manager\Models\Role;

class UserController extends Controller
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
            $this->middleware(['permission:user.index'])->only(['index', 'show']);
            $this->middleware(['permission:user.update'])->only(['edit', 'update']);
            $this->middleware(['permission:user.create'])->only(['create', 'store']);
            $this->middleware(['permission:user.delete'])->only(['destroy']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index', [
            'users' => User::with('roles')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create', [
            'user'    => [],
            'roles' => $this->hasModuleRole  ? Role::all() : [],
            'permissions' => $this->hasModuleRole ? Permission::all() : [],
            'model' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'active' => $request['active'],
            ]);
        } catch (\Exception $e) {
            return redirect()->route('admin.user.create')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', [
            'user'    => $user,
            'roles' => $this->hasModuleRole ? Role::all() : [],
            'permissions' => $this->hasModuleRole ? Permission::all() : [],
            'model' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $user->name = $request['name'];
            $user->email = $request['email'];
            $request['password'] == null ?: $user->password = Hash::make($request['password']);
            $user->active = $request['active'];

            $user->save();

            return redirect()->route('admin.user.index')
                ->with('success', trans('common.update_successful'));
        } catch (\Exception $e) {
            return redirect()->route('admin.user.edit', $user)
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index');
    }
}
