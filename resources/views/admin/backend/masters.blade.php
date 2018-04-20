@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>ユーザー管理</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="row">
            <div class="box">
                <div class="box-body">
                    <form role="form">
                        <p>新しくユーザーを追加する場合は以下のボタンを押してください。</p>
                        <button type="submit" class="btn btn-primary btn-flat">ユーザー追加</button>
                    </form>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <p class="box-note"><span>11 件目～20件目</span> <span>計: 35件</span></p>

                    <div class="box-tools">
                        <ul class="pagination pagination-sm no-margin pull-right">

                            {!! $sourcePhoneNumber->links() !!}
                        </ul>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>id</th>
                            <th>名前</th>
                            <th>ログインID</th>
                            <th>ロック</th>
                            <th>作成日時</th>
                        </tr>
                        @foreach($sourcePhoneNumber as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->phone_number }}</td>
                                <td>{{ $row->description }}</td>
                                <td><span class="glyphicon glyphicon-lock"></span></td>
                                <td>{{ $row->created_at }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@endsection