@extends('layouts.supply_front')

@section('title') {{__('supply.company.title_screen')}}
@stop

@section('js')
    <script type="text/javascript" src="{{ asset('js/address.js').'?'.strtotime(date('d-m-Y h:i:s'))  }}"></script>
    <script type="text/javascript" src="{{ asset('js/company.js').'?'.strtotime(date('d-m-Y h:i:s')) }}"></script>
@stop
