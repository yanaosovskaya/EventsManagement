@extends('layouts.app')

@section('content')
    <div class="error-page">
        <h2 class="headline text-info"> 403</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> {{ __('Restricted Access: 403 (Forbidden)') }}</h3>
            <p>
                {!! __('Perhaps you would like to go to our <a href=":route">home page</a>?', ['route' => route('home')]) !!}
            </p>
        </div>
    </div>
@endsection
