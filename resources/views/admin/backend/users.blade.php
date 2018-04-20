@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<!--section class="content-header">
    <h1>
        ユーザー管理
        <small>新しくユーザーを追加する場合は以下のボタンを押してください。</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{Route('dashboard')}}"><i class="fa fa-dashboard"></i> Zenrin-Data</a></li>
        <li class="active">Users</li>
    </ol>
</section-->
<!-- Main content -->
<section class="content container-fluid">

    <div class="row">

        <div class="box">
            <!-- Box Body -->
            <div class="box-body">
                <form role="form">

                    <p>新しくユーザーを追加する場合は以下のボタンを押してください。</p>
                    <button type="submit" class="btn btn-primary btn-flat">ユーザー追加</button>

                </form>
            </div>
            <!-- End Box Body -->
        </div>
        <style>
            .pagination{
                margin:0px !important;
            }
        </style>
        <!-- Box Body -->
        <div id="userBox" class="box">
        	@include('admin.backend.users_ajax')
        </div>
        <!-- End Box -->
    </div>

</section>
<!-- /.content -->
@endsection