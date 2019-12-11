@extends('layouts.supply_front')

@section('title') {{__('supply.user.create')}}
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user.css').'?'.strtotime(date('d-m-Y h:i:s')) }}" />
@stop
@section('js')
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/user.js').'?'.strtotime(date('d-m-Y h:i:s')) }}"></script>
@stop
