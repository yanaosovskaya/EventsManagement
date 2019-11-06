@php
    /**
    * @var $menu App\Models\Menu
    **/
@endphp

<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label">{{ trans('menu.fields.name') }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
               name="name" placeholder="{{ trans('menu.fields.name') }}"
               value="{{ old('name', $menu ? $menu->name : "") }}" required autofocus>

        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label">{{ trans('menu.fields.code') }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}"
               name="code" placeholder="{{ trans('menu.fields.code') }}"
               value="{{ old('code', $menu ? $menu->code : "") }}" required>

        @if ($errors->has('code'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('code') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label">{{ trans('menu.fields.type') }}</label>
    <div class="col-sm-10">
        <select class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" placeholder="{{ trans('menu.fields.type') }}">
            @foreach(\App\Models\Menu::$types as $key => $type)
                <option value="{{ $key }}"
                        {{ old('type', $menu && ($menu->type == $key)) ? 'selected' : '' }}>
                    {{ \App\Models\Menu::getType($key) }}
                </option>
            @endforeach
        </select>

        @if ($errors->has('code'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('code') }}</strong>
            </span>
        @endif
    </div>
</div>



