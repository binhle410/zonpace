@extends('backend.layouts.master')

@section('title', trans('labels.backend.houses.management'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.houses.management') }}
        <small>{{ trans('labels.backend.houses.active') }}</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.houses.active') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.houses.partials.header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ trans('labels.backend.houses.table.id') }}</th>
                        <th>{{ trans('labels.backend.access.users.table.email') }}</th>
                        <th>{{ trans('labels.backend.houses.table.name') }}</th>
                        <th>{{ trans('labels.backend.houses.table.display_name') }}</th>
                        <th>{{ trans('labels.backend.houses.table.nor') }}</th>
                        <th>{{ trans('labels.backend.houses.table.max_guest') }}</th>
                        <th>{{ trans('labels.general.status') }}</th>
                        <th class="visible-lg">{{ trans('labels.backend.houses.table.created') }}</th>
                        <th class="visible-lg">{{ trans('labels.backend.houses.table.last_updated') }}</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($houses as $house)
                        <tr>
                            <td>{!! $house->id !!}</td>
                            <td>{!! link_to("#", $house->user->email) !!}</td>
                            <td>{!! $house->name !!}</td>
                            <td>{!! $house->display_name !!}</td>
                            <td>{!! $house->nor !!}</td>
                            <td>{!! $house->max_guest !!}</td>
                            <td>{!! $house->status_label !!}</td>
                            <td class="visible-lg">{!! $house->created_at->diffForHumans() !!}</td>
                            <td class="visible-lg">{!! $house->updated_at->diffForHumans() !!}</td>
                            <td>{!! $house->action_buttons !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pull-left">
                {!! $houses->total() !!} {{ trans_choice('labels.backend.houses.table.total', $houses->total()) }}
            </div>

            <div class="pull-right">
                {!! $houses->render() !!}
            </div>

            <div class="clearfix"></div>
        </div><!-- /.box-body -->
    </div><!--box-->

@stop