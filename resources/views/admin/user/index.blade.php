@extends('layouts.admin.app')

@section('title')
    {{ trans('user.title') }}
@endsection

@section('content')

    <div class="container">
        @userCan('user.create')
            <a href="{{route('admin.user.create')}}" class="btn btn-primary pull-right">
                <i class="fas fa-plus"></i> {{ trans('common.create') }}
            </a>
        @endUserCan
        <table class="table table-stripped">
            <thead>
            <tr>
                <th>
                    {{ trans('user.id') }}
                </th>
                <th>
                    {{ trans('user.first_name') }}
                </th>
                <th>
                    {{ trans('user.last_name') }}

                </th>
                <th>
                    {{ trans('user.email') }}
                </th>

                @if ($hasRoleModule)
                    <th>{{ trans('manager::main.user.role') }}</th>
                @endif

                <th>
                    {{ trans('user.created') }}
                </th>
                <th>
                    {{ trans('user.active') }}
                </th>
                <th>
                    {{ trans('user.action') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->first_name}}</td>
                    <td>{{$user->last_name}}</td>

                    <td>{{$user->email}}</td>

                    @if ($hasRoleModule)
                       <td>{{ $user->roles[0]->name }}</td>
                    @endif

                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->isActive() ? trans('common.yes') : trans('common.no') }}</td>
                    <td>
                        @userCan('user.update')
                            <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-default d-inline-block" title="{{ trans('common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endUserCan

                        @userCan('user.delete')
                            <form onsubmit="if(confirm('Delete?')) { return true;} else { return false; }"
                                  action="{{ route('admin.user.destroy', $user) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-default" type="submit" title="{{ trans('common.delete') }}"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        @endUserCan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $hasRoleModule ? 7 : 6 }}" class="text-center">
                        <h2>{{ trans('common.no_data') }}</h2>
                    </td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td colspan="{{ $hasRoleModule ? 7 : 6 }}">
                    {{$users->links()}}
                </td>
            </tr>
            </tfoot>
        </table>
    </div>

@endsection
