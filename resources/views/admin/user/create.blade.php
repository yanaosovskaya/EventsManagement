@extends('layouts.admin.app')

@section('content')

    <div class="container">
        <form class="form-horizontal" action="{{route('admin.user.store')}}" method="post">
            {{csrf_field()}}

            @include('admin.user.partials.form', [
                'user'    => $user,
            ])

            @if ($hasRoleModule)
                @permission('role.create')
                    @include('manager::admin.user.partials.form-role')

                    @include('manager::admin.role.permission.index')
                @endpermission
            @endif

            <hr/>

            <a href="{{ route('admin.user.index') }}" class="btn btn-default">
                {{ trans('common.cancel') }}
            </a>
            <input type="submit" class="btn btn-primary" value="{{ trans('common.save') }}">

        </form>
    </div>

@endsection
