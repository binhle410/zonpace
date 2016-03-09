@extends('backend.layouts.login')
@section('box-title')
    {{ trans('labels.frontend.auth.login_box_title') }}
@endsection
@section('box-msg')
    {{ trans('Sign in to start your session') }}
@endsection
@section('content')
    {!! Form::open(['url' => route('backend.post-login')]) !!}
        <div class="form-group has-feedback">
            {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.email')]) !!}
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.password')]) !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        {!! Form::checkbox('remember') !!} {{ trans('labels.frontend.auth.remember_me') }}
                    </label>
                </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
                {!! Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'btn btn-primary btn-block btn-flat', 'style' => 'margin-right:15px']) !!}
            </div><!-- /.col -->
        </div>
    {!! Form::close() !!}

    {!! link_to_route('backend.password.reset', trans('labels.frontend.passwords.forgot_password')) !!}
@endsection
@section('after-scripts-end')
    <!-- iCheck -->
    {!! Html::script('js/vendor/iCheck/icheck.min.js') !!}

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
@endsection