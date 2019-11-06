@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($profile && $profile->image)
            <img src="{{ asset('storage/avatar/'.$profile->image->image_name) }}" alt="{{$user->first_name}}">
            @else 
            <img src="{{ url('images/default-avatar.png') }}" alt="{{$user->first_name}}">
            @endif
            <br><br>
            <div class="col-md-6 text-center">
                @if(Auth::user()->id === $user->id)
                    <a href="{{ route('profiles.edit', ['id' => Auth::user()->id])}}" class="btn btn-primary btn-block">Edit profile</a>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <table class="table">
                <tr>
                    <th>First name</th>
                    <td>{{ $user->first_name}}</td>
                </tr>
                <tr>
                    <th>Last name</th>
                    <td>{{ $user->last_name}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$user->email}}</td>
                </tr>
                @if($user->profile)
                <tr>
                    <th>Birhday</th>
                    <td>{{ $birhdate ? $birhdate->toFormattedDateString() : ''}}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $user->profile->phone }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td>{{ $user->profile->city }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

</div>
@endsection