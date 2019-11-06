@extends('layouts.admin.app')

@section('content')

    <div class="container">
        <form class="form-horizontal" action="{{route('admin.snippet.store')}}" method="post">
            @csrf

            @include('admin.snippet.partials.form', [
                'snippet'    => $snippet,
                'slugs' => $slugs,
            ])

            <hr/>

            <a href="{{ route('admin.snippet.index') }}" class="btn btn-default">
                {{ trans('common.cancel') }}
            </a>
            <input type="submit" class="btn btn-primary" value="{{ trans('common.save') }}">

        </form>
    </div>

@endsection
