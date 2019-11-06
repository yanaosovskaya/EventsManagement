@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h1>Edit profile</h1>
                <form method="POST" action="{{ route('profiles.update', ['id' => $user->id])}}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">First name:</label>
                        <input type="text" class="form-control" id="name" name="first_name" value="{{$user->first_name}}">
                    </div>
                    <div class="form-group">
                            <label for="name">Last name:</label>
                            <input type="text" class="form-control" id="name" name="last_name" value="{{$user->last_name}}">
                        </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                    </div>
                    
                    <div class="form-group">
                        <label for="birhdate">Birhdate:</label>
                        <input type="date" class="form-control" id="birhdate" name="birhdate" value="{{$user->profile->birhdate ?? ''}}">
                    </div>
                    @if($profile && $profile->image)
                    <div class="form-group">
                        <label for="photo">Avatar:</label>
                        <img class="img-thumbnail" src="{{ asset('storage/avatar/'.$profile->image->image_name) }}" alt="{{$user->first_name}}" width="100px;">
                    </div>
                    <div class="form-group">
                        <label for="adress_line2">Replace avatar:</label>
                        <input type="file" class="form-control" id="photo" name="avatar" >
                    </div>
                    @else 
                    <div class="form-group">
                        <label for="adress_line2">Download avatar:</label>
                        <input type="file" class="form-control" id="photo" name="avatar" >
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="province">Phone:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{$user->profile->phone ?? ''}}">
                    </div>
                    <div class="form-group">
                            <label for="province">City:</label>
                            <input type="text" class="form-control" id="phone" name="city" value="{{$user->profile->city ?? ''}}">
                        </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection