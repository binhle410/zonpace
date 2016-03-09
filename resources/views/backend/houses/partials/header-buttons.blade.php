    <div class="pull-right" style="margin-bottom:10px">
        <div class="btn-group">
          <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              {{ trans('menus.backend.houses.main') }} <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="{{ route('admin.houses.index') }}">{{ trans('menus.backend.houses.all') }}</a></li>
            <li class="divider"></li>
            <li><a href="{{ route('admin.houses.create') }}">{{ trans('menus.backend.houses.create') }}</a></li>
          </ul>
        </div><!--btn group-->
    </div><!--pull right-->

    <div class="clearfix"></div>
