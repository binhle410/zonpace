@extends('backend.layouts.login')

@section('box-title')
    {{ trans('labels.frontend.passwords.reset_password_box_title') }}
@endsection

@section('box-msg')
    {{ trans('Please enter exactly email address.') }}
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {!! Form::open(['url' => route('backend.password.post-email')]) !!}
        <div class="form-group">
            {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.email')]) !!}
        </div><!--form-group-->
        <div class="form-group">
            {!! Form::submit(trans('labels.frontend.passwords.send_password_reset_link_button'), ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@endsection
