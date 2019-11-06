@extends('layouts.admin.app')

@section('title')
    {{ trans('menu.title') }}
@endsection

@section('content')
    <div class="container">
        <form action="{{route('admin.menu.store')}}" method="post">
            @csrf

            @include('admin.menu.partials.form', [
                'menu'    => $menu,
            ])

            <hr/>

            <a href="{{ route('admin.menu.index') }}" class="btn btn-default">
                {{ trans('common.cancel') }}
            </a>
            <input type="submit" class="btn btn-primary" value="{{ trans('common.save') }}">

        </form>
    </div>
@endsection

