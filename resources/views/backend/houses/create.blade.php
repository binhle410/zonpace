@extends ('backend.layouts.master')

@section ('title', trans('labels.backend.houses.management') . ' | ' . trans('labels.backend.houses.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.houses.management') }}
        <small>{{ trans('labels.backend.houses.create') }}</small>
    </h1>
@endsection

@section('content')
    @include('backend.houses.partials.form')
@stop

@section('after-scripts-end')
    {!! Html::script('js/backend/access/permissions/script.js') !!}
    {!! Html::script('js/backend/access/users/script.js') !!}
@stop
