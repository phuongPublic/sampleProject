@extends('layouts.supply_front')

@section('title') {{__('supply.job.create')}}
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jobs.css').'?'.strtotime(date('d-m-Y h:i:s')) }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bs-material/bootstrap-material-datetimepicker.css') }}" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@stop
@section('js')
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/job.js').'?'.strtotime(date('d-m-Y h:i:s'))  }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/address.js').'?'.strtotime(date('d-m-Y h:i:s'))  }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/bs-material/moment-with-locales.min.js') }}"></script>
    <script language="JavaScript" type="text/javascript" src="{{ asset('js/bs-material/bootstrap-material-datetimepicker.js') }}"></script>
@stop
