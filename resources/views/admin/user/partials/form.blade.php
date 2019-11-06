@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<label for="">{{ trans('user.name') }}</label>
<input type="text" class="form-control" name="name" placeholder="{{ trans('user.name') }}" value="{{ old('name', $user ? $user->name : "") }}" required>

<label for="">{{ trans('user.email') }}</label>
<input type="email" class="form-control" name="email" placeholder="{{ trans('user.email') }}" value="{{ old('email', $user ? $user->email : "") }}" required>

<label for="">{{ trans('user.password') }}</label>
<input type="password" class="form-control" name="password">

<label for="">{{ trans('user.password_confirm') }}</label>
<input type="password" class="form-control" name="password_confirmation">

<label for="">{{ trans('user.active') }}</label>
<div class="form-check-inline">
    <label class="form-check-label">
        <input type="radio" class="form-check-input" name="active" value="1" {{ !$user ? 'checked' : $user && $user->isActive() ? 'checked' : '' }}> @lang('common.yes')
    </label>
</div>
<div class="form-check-inline">
    <label class="form-check-label">
        <input type="radio" class="form-check-input" name="active" value="0" {{ $user && !$user->isActive() ? 'checked' : '' }}> @lang('common.no')
    </label>
</div>

<div class="clearfix"></div>
