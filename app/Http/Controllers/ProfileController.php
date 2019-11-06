<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Carbon\Carbon;
use Auth;
use App\Http\Requests\ProfileRequest;
use App\Repositories\ProfileRepository;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->middleware('auth');
        $this->profileRepository = $profileRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $birhdate = $user->profile && $user->profile->birhdate ? Carbon::parse($user->profile->birhdate) : null;
        $profile = Profile::where('user_id', $id)->first();
        
        return view('profile.show', ['user' => $user, 'birhdate' => $birhdate, 'profile' => $profile]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $profile = Profile::where('user_id', $id)->first();
        $this->authorize('edit', $profile);
        
        return view('profile.edit')->with(['user' => $user, 'profile' => $profile]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        $this->profileRepository->update($request, $id);
              
        return back()->with('success', trans('user.profile.update_successful'));
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
