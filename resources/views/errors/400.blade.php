@extends('layouts.app')

@section('content')
    <div class="error-page">
        <h2 class="headline text-info"> 400</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> {{ __('Bad request.') }} </h3>
            <p>
                {!! __('Perhaps you would like to go to our <a href=":route">main page</a>?', ['route' => route('home')]) !!}
            </p>
        </div>
    </div>
@endsection
