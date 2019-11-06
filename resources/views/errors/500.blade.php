@extends('layouts.app')

@section('content')
    <div class="error-page">
        <h2 class="headline text-info"> 500</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> {{ __('Server Error') }} </h3>
            <p>
                {{$exception->getMessage()}}
            </p>
        </div>
    </div>
@endsection
