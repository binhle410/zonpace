@extends('backend.layouts.login')

@section('box-title')
    {{ trans('labels.frontend.passwords.reset_password_box_title') }}
@endsection

@section('box-msg')
    {{ trans('Please enter exactly email and old password.') }}
@endsection

@section('content')
    {!! Form::open(['url' => route('backend.password.post-reset')]) !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.email')]) !!}
        </div><!--form-group-->

        <div class="form-group">
            {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.password')]) !!}
        </div><!--form-group-->

        <div class="form-group">
            {!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.password_confirmation')]) !!}
        </div><!--form-group-->

        <div class="form-group">
            {!! Form::submit(trans('labels.frontend.passwords.reset_password_button'), ['class' => 'btn btn-primary']) !!}
        </div><!--form-group-->

    {!! Form::close() !!}
@endsection