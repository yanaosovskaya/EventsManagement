@extends('layouts.admin.app')

@section('content')
    <div class="container">
        <form action="{{route('admin.setting.store')}}" method="post">
            @csrf

            @include('admin.setting.partials.form', [
                'setting'    => $setting,
            ])

            <hr/>

            <a href="{{ route('admin.setting.index') }}" class="btn btn-default">
                {{ trans('common.cancel') }}
            </a>
            <input type="submit" class="btn btn-primary" value="{{ trans('common.save') }}">

        </form>
    </div>
@endsection

