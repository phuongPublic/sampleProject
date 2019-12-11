<div class="col-12">
    <div class="text-right m-b-15">
        <a class="btn m-l-15
        @if(Request::is('admin/kpi')
        || Request::is('admin/kpi/job-type')
        || Request::is('admin/kpi/jlpt')
        || Request::is('admin/kpi/important')
        || Request::is('admin/kpi/station')
        || Request::is('admin/kpi/sequence')
        || Request::is('admin/kpi/cumulative-sequence')
        )
            btn-primary
        @else
            btn-outline-primary
        @endif
            " href="{{route('admin.kpi.index')}}">Supply Side</a>

        <a class="btn m-l-15
        @if(Request::is('admin/kpi/demand') || Request::is('admin/kpi/demand/job-type') || Request::is('admin/kpi/demand/jlpt') || Request::is('admin/kpi/demand/important') || Request::is('admin/kpi/demand/station') )
            btn-primary
        @else
            btn-outline-primary
        @endif
            " href="{{ route('admin.kpi.demand.index')}}">Demand Side</a>
        <a class="btn m-l-15 btn btn-outline-primary" href="#">Function</a>
        <a class="btn m-l-15 btn btn-outline-primary" href="#">CSV DL</a>
    </div>
</div>
