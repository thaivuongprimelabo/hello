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
        <div class="box">
            <div class="box-header">
                <div class="col-lg-10">
                    <p><span>11 件目～20件目</span> <span>計: 35件</span></p>
                </div>
                <div class="col-lg-2" style="text-align:center;">
                    {{$users->links()}}
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover ">
                    <tbody class="users" style="position: relative;">
                        @include('admin.backend.users_ajax')
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- End Box -->
    </div>

</section>
<!-- /.content -->
@endsection