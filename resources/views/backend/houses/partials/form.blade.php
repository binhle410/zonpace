@if (isset($house))
    {!! BootForm::openHorizontal(['lg' => [2, 10]])->action(route('admin.houses.update', $house->id))->put() !!}
    {!! BootForm::bind($house) !!}
@else
    {!! BootForm::openHorizontal(['lg' => [2, 10]])->action(route('admin.houses.store')) !!}
@endif

<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('labels.backend.houses.' . (isset($house) ? 'edit' : 'create')) }}</h3>

        <div class="box-tools pull-right">
            @include('backend.houses.partials.header-buttons')
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        {!! BootForm::select(trans('validation.attributes.backend.houses.user_id'), 'user_id')->options($users->pluck('email', 'id')->all())->class('form-control select2') !!}
        {!! BootForm::text(trans('validation.attributes.backend.houses.name'), 'name')->placeholder(trans('validation.attributes.backend.houses.name')) !!}
        {!! BootForm::text(trans('validation.attributes.backend.houses.display_name'), 'display_name')->placeholder(trans('validation.attributes.backend.houses.display_name')) !!}
        {!! BootForm::text(trans('validation.attributes.backend.houses.nor'), 'nor')->type('number')->min(1)->step(1)->placeholder(trans('validation.attributes.backend.houses.nor')) !!}
        {!! BootForm::text(trans('validation.attributes.backend.houses.max_guest'), 'max_guest')->type('number')->min(1)->step(1)->placeholder(trans('validation.attributes.backend.houses.max_guest')) !!}
        {!! BootForm::select(trans('validation.attributes.backend.houses.status'), 'status')->options(getStatusList())->class('form-control select2') !!}
    </div><!-- /.box-body -->
</div><!--box-->

<div class="box box-info">
    <div class="box-body">
        <div class="pull-left">
            {{ Html::link(route('admin.houses.index'), trans('buttons.general.cancel'), ['class' => 'btn btn-danger btn-xs']) }}
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="{{ trans('buttons.general.crud.' . (isset($house) ? 'update' : 'create')) }}" />
        </div>
        <div class="clearfix"></div>
    </div><!-- /.box-body -->
</div><!--box-->

{!! BootForm::close() !!}