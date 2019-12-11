<div class="col-2">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link {{ Request::is('admin/kpi/demand') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/demand') ? '#' : route('admin.kpi.demand.index')  }}">{{__('supply.kpi.demand.title_index')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/demand/job-type') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/demand/job-type') ? '#': route('admin.kpi.demand.job_type')}}">{{__('supply.kpi.demand.job_type')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/demand/jlpt') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/demand/jlpt') ? '#': route('admin.kpi.demand.jlpt')}}">{{__('supply.kpi.demand.title_jlpt')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/demand/important') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/demand/important') ? '#': route('admin.kpi.demand.important')}}">{{__('supply.kpi.demand.title_important')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/demand/station') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/demand/station') ? '#': route('admin.kpi.demand.station')}}">{{__('supply.kpi.demand.title_station')}}</a>
    </div>
</div>
