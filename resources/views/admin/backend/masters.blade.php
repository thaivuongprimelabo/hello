@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Masters
    <small>Optional description</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{Route('dashboard')}}"><i class="fa fa-dashboard"></i>{{Config::get('master.Home_Title')}}</a></li>
    <li class="active">Masters</li>
  </ol>
</section>
<!-- Main content -->
<section class="content container-fluid">


</section>
<!-- /.content -->
@endsection