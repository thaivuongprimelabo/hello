@extends('layouts.app')
@section('content')

<section class="content-header">
    <h1>ユーザー管理</h1>
    <ol class="breadcrumb">
        <li><a href="{{Route('dashboard')}}"><i class="fa fa-dashboard"></i>{{Config::get('master.Home_Title')}}</a></li>
        <li class="active">Users</li>
    </ol>
</section>

<section class="content container-fluid">
    <div class="row">
        <div class="box">
            <div class="box-body">
                <form role="form">
                    <p>新しくユーザーを追加する場合は以下のボタンを押してください。</p>
                    <a href="/admin/users/new" class="btn btn-primary btn-flat">ユーザー追加</a>
                </form>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <p class="box-note"><span>11 件目～20件目</span> <span>計: 35件</span></p>
                <div class="box-tools">
                    {!! $users->links() !!}
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody><tr>
                        <th>id</th>
                        <th>名前</th>
                        <th>ログインID</th>
                        <th>ロック</th>
                        <th>作成日時</th>
                    </tr>
                    @foreach($users as $user)
                        <tr class="user-row" data-text="{{ $user->id }}">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->loginid }}</td>
                            <td><?= ($user->locked == 1) ? '<span class="glyphicon glyphicon-lock"></span>' : ''; ?></td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>
@section('script')
    <script>
        $(document).ready(function(){
            $('.user-row').click(function(){
                console.log();
                window.location.href = 'users/edit/'+$(this).attr('data-text');
            })
        });
    </script>
@endsection
@endsection
