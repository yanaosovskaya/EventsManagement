@extends('layouts.admin.app')

@section('title')
    {{ trans('snippet.title') }}
@endsection

@php
/**
* @var $snippets \App\Models\Snippet[]
**/
@endphp

@section('content')
    <div class="container">
        @userCan('snippet.create')
            <a href="{{route('admin.snippet.create')}}" class="btn btn-primary pull-right">
                <i class="fas fa-plus"></i> {{ trans('common.create') }}
            </a>
        @endUserCan
        <table class="table table-stripped">
            <thead>
            <tr>
                <th>
                    {{ trans('snippet.fields.id') }}
                </th>
                <th>
                    {{ trans('snippet.fields.name') }}
                </th>
                <th>
                    {{ trans('snippet.fields.visible') }}
                </th>

                <th>
                    {{ trans('snippet.fields.location') }}
                </th>
                <th>
                    {{ trans('user.action') }}
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($snippets as $snippet)
                <tr>
                    <td>{{ $snippet->id }}</td>
                    <td>{{ $snippet->name }}</td>
                    <td>{{ \App\Models\Snippet::getVisibilityStatus($snippet->visible) }}</td>
                    <td>{{ \App\Models\Snippet::getLocationStatus($snippet->location) }}</td>

                    <td>
                        @userCan('snippet.update')
                            <a href="{{ route('admin.snippet.edit', $snippet) }}" class="btn btn-default d-inline-block" title="{{ trans('common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endUserCan

                        @userCan('snippet.delete')
                            <form onsubmit="if(confirm('Delete?')) { return true;} else { return false; }"
                                  action="{{ route('admin.snippet.destroy', $snippet) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-default" type="submit" title="{{ trans('common.delete') }}"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        @endUserCan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 5 }}" class="text-center">
                        <h2>{{ trans('common.no_data') }}</h2>
                    </td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td colspan="{{ 5 }}">
                    {{$snippets->links()}}
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
