@extends('layouts.admin.app')

@section('title')
    {{ trans('menu.title') }}
@endsection

@php
/**
* @var $menu App\Models\Menu
**/
@endphp

@section('content')

    <div class="container">
        @userCan('menu.create')
            <a href="{{route('admin.menu.create')}}" class="btn btn-primary pull-right">
                <i class="fas fa-plus"></i> {{ trans('common.create') }}
            </a>
        @endUserCan
        <table class="table table-stripped">
            <thead>
            <tr>
                <th>
                    {{ trans('menu.fields.id') }}
                </th>
                <th>
                    {{ trans('menu.fields.name') }}
                </th>
                <th>
                    {{ trans('menu.fields.type') }}
                </th>
                <th>
                    {{ trans('menu.fields.code') }}
                </th>
                <th>
                    {{ trans('menu.count_items') }}
                </th>

                <th>
                    {{ trans('menu.updated') }}
                </th>
                <th>
                    {{ trans('menu.action') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($menus as $menu)
                <tr>
                    <td>{{ $menu->id }}</td>
                    <td>{{ $menu->name }}</td>
                    <td>{{ \App\Models\Menu::getType($menu->type) }}</td>
                    <td>{{ $menu->code }}</td>
                    <td>{{ \App\Services\MenuItem::getItems($menu)->count() }}</td>
                    <td>{{ $menu->updated_at }}</td>
                    <td>
                        @userCan('menu.update')
                            <a href="{{ route('admin.menu.edit', $menu) }}" class="btn btn-default d-inline-block" title="{{ trans('common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endUserCan

                        @userCan('menu.delete')
                            <form onsubmit="if(confirm('Delete?')) { return true;} else { return false; }"
                                  action="{{ route('admin.menu.destroy', $menu) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-default" type="submit" title="{{ trans('common.delete') }}"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        @endUserCan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 7 }}" class="text-center">
                        <h2>{{ trans('common.no_data') }}</h2>
                    </td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td colspan="{{ 7 }}">
                    {{$menus->links()}}
                </td>
            </tr>
            </tfoot>
        </table>
    </div>

@endsection
