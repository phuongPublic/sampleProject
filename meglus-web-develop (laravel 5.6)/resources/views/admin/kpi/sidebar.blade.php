<div class="col-2">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link {{ Request::is('admin/kpi') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi') ? '#' : route('admin.kpi.index')  }}">{{__('supply.kpi.title_index')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/sequence') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/sequence') ? '#': route('admin.kpi.sequence')}}">{{__('supply.kpi.sequence')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/cumulative-sequence') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/cumulative-sequence') ? '#': route('admin.kpi.cumulative-sequence')}}">{{__('supply.kpi.cumulative-sequence')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/jlpt') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/jlpt') ? '#': route('admin.kpi.jlpt')}}">{{__('supply.kpi.title_jlpt')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/important') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/important') ? '#': route('admin.kpi.important')}}">{{__('supply.kpi.title_important')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/job-type') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/job-type') ? '#': route('admin.kpi.job_type')}}">{{__('supply.kpi.job_type')}}</a>
        <a class="nav-link {{ Request::is('admin/kpi/station') ? 'active show' : '' }}" href="{{ Request::is('admin/kpi/station') ? '#': route('admin.kpi.station')}}">{{__('supply.kpi.title_station')}}</a>
    </div>
</div>
