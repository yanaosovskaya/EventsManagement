@extends('layouts.app')

@section('content')
    <div class="error-page">
        <h2 class="headline text-info"> 404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> {{ __('Oops! Page not found.') }}</h3>
            <p>
               {!! __(' We could not find the page you were looking for.
                Perhaps you would like to go to our <a href=":route">home page</a>?', ['route' => '/']) !!}
            </p>
        </div>
    </div>
@endsection
