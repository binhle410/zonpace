@extends('backend.layouts.login')

@section('box-title')
    {{ trans('labels.frontend.user.passwords.change') }}
@endsection

@section('box-msg')
    {{ trans('Password and confirm should be exactly same.') }}
@endsection

@section('content')
    {!! Form::open(['route' => ['auth.password.update']]) !!}

        <div class="form-group">
            {!! Form::input('password', 'old_password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.old_password')]) !!}
        </div>
        <div class="form-group">
            {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.new_password')]) !!}
        </div>
        <div class="form-group">
            {!! Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.new_password_confirmation')]) !!}
        </div>

        <div class="form-group">
            {!! Form::submit(trans('labels.general.buttons.update'), ['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
@endsection