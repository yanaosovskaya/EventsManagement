@extends('layouts.app')

@section('title')
   {{ trans('contact-form.contact_form') }}
@endsection

@section('content')
    <div class="row">
        <div class="container">
            <div class="form-group">
                <div class="col-md-6">
                    {{ trans('contact-form.info_text') }}
                </div>
            </div>

            <form method="POST" action="{{ route('contact-form.store') }}"
                  aria-label="{{ trans('contact-form.contact_form') }}" id="theForm">
                @csrf

                <div class="form-group">
                    <label for="email" class="col-md-4 col-form-label">{{ trans('contact-form.fields.email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               name="email" value="{{ \Auth::check() ? \Auth::user()->email : old('email') }}"
                               placeholder="{{ trans('contact-form.fields.email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="full-name"
                           class="col-sm-4 col-form-label">{{ trans('contact-form.fields.full_name') }}</label>

                    <div class="col-md-6">
                        <input id="full-name" type="text"
                               class="form-control{{ $errors->has('full_name') ? ' is-invalid' : '' }}"
                               name="full_name" value="{{ old('full_name') }}"
                               placeholder="{{ trans('contact-form.fields.full_name') }}" required>

                        @if ($errors->has('full_name'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('full_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="subject"
                           class="col-sm-4 col-form-label">{{ trans('contact-form.fields.subject') }}</label>

                    <div class="col-md-6">
                        <input id="subject" type="text"
                               class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}"
                               name="subject" placeholder="{{ trans('contact-form.fields.subject') }}"
                               value="{{ old('subject') }}" required>

                        @if ($errors->has('subject'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('subject') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="message"
                           class="col-sm-4 col-form-label">{{ trans('contact-form.fields.message') }}</label>

                    <div class="col-md-6">
                <textarea id="message" type="text"
                          class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}"
                          name="message" placeholder="{{ trans('contact-form.fields.message') }}"
                          required>{{ old('message') }}</textarea>

                        @if ($errors->has('message'))
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-1">
                        @if ($isCaptcha)
                            <button type="submit" class="btn btn-primary g-recaptcha"
                                    data-sitekey="{{ env('INVISIBLE_RECAPTCHA_SITEKEY') }}" data-callback="submitForm">
                                {{ trans('contact-form.btn_submit') }}
                            </button>
                        @else
                            <button type="submit" class="btn btn-primary">
                                {{ trans('contact-form.btn_submit') }}
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@if ($isCaptcha)
    @push('scripts')
        <script src='https://www.google.com/recaptcha/api.js'></script>

        <script>
            function submitForm() {
                document.getElementById("theForm").submit();
            }
        </script>
    @endpush
@endif
