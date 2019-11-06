@extends('layouts.admin.app')

@section('title')
   {{ trans('setting.title') }}
@endsection

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            @userCan('setting.create')
                <a href="{{route('admin.setting.create')}}" class="btn btn-primary pull-right">
                    <i class="fas fa-plus"></i> {{ trans('setting.add_setting') }}
                </a>
            @endUserCan
        </div>
        <div class="card-body">
            @foreach(\App\Models\Setting::$groups as $group => $caption)
                <div class="card">
                    <div class="card-header">
                        {{ \App\Models\Setting::getGroup($group) }}
                    </div>
                    <div class="card-body">
                        @foreach($settings as $setting)
                            @if ($setting->groups == $group)
                                <form>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label col-form-label-lg">{{ $setting->title }}</label>
                                        <label class="col-sm-4 col-form-label col-form-label-lg">{{ $setting->key }}</label>
                                        <label class="col-sm-5 col-form-label col-form-label-lg">{{ $setting->value }}</label>
                                        @userCan('setting.update')
                                            <div class="col-sm-1">
                                                <a href="{{ route('admin.setting.edit', $setting) }}" class="btn btn-default" title="{{ trans('common.edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        @endUserCan
                                    </div>
                                </form>
                            @endif
                        @endforeach
                    </div>
                </div>
                <br>
            @endforeach

        </div>
    </div>

@endsection
