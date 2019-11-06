<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label">{{ trans('setting.fields.title') }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
               name="title" placeholder="{{ trans('setting.fields.title') }}"
               value="{{ old('title', $setting ? $setting->title : "") }}" required autofocus>

        @if ($errors->has('title'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label">{{ trans('setting.fields.key') }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control{{ $errors->has('key') ? ' is-invalid' : '' }}"
               name="key" placeholder="{{ trans('setting.fields.key') }}"
               value="{{ old('key', $setting ? $setting->key : "") }}" required {{ $setting ? "disabled" : "" }}>

        @if ($errors->has('key'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('key') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-2 col-form-label">{{ trans('setting.fields.value') }}</label>
    <div class="col-sm-10">
        @if ($setting)
            @switch($setting->type)
                @case(\App\Models\Setting::TYPE_STRING)
                    <input type="text" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}"
                       name="value" placeholder="{{ trans('setting.fields.value') }}"
                       value="{{ old('value', $setting ? $setting->value : "") }}">
                @break

                @case(\App\Models\Setting::TYPE_TEXT)
                    <textarea class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" name="value" placeholder="{{ trans('setting.fields.value') }}">
                        {{ old('value', $setting ? $setting->value : "") }}
                    </textarea>
                @break

                @case(\App\Models\Setting::TYPE_SELECT)
                {{--//--}}
                @break

                @case(\App\Models\Setting::TYPE_MULTI_SELECT)
                    @if ($setting->groups == \App\Models\Setting::GROUP_CONTACT_FORM)
                        <select class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}" name="value[]" placeholder="{{ trans('setting.fields.value') }}" multiple>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->email }}"
                                        {{$setting->value ? (in_array($user->email, json_decode($setting->value, true)) ? 'selected' : '') : '' }}>
                                    {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    {{--//--}}
                @break

                @case(\App\Models\Setting::TYPE_RADIO)
                    @if ($setting->groups == \App\Models\Setting::GROUP_CONTACT_FORM)
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="value" value="1" {{ $setting->value ? 'checked' : '' }}>Yes
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="value" value="0" {{ !$setting->value ? 'checked' : '' }}>No
                            </label>
                        </div>
                    @endif
                @break

            @endswitch
        @else
            <input type="text" class="form-control{{ $errors->has('value') ? ' is-invalid' : '' }}"
                   name="value" placeholder="{{ trans('setting.fields.value') }}"
                   value="{{ old('value', $setting ? $setting->value : "") }}">
        @endif

        @if ($errors->has('value'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('value') }}</strong>
            </span>
        @endif
    </div>
</div>


