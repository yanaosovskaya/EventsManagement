@extends('layouts.app')

@section('content')
    <div class="error-page">
        <h2 class="headline text-info"> 401</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> {{ __('Unauthorized.') }} </h3>
            <p>
                {!! __('Perhaps you would like to go to our <a href=":route">login page</a>?', ['route' => route('login')]) !!}
            </p>
        </div>
    </div>
@endsection
