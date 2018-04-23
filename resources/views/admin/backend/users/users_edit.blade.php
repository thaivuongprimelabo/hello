@extends('layouts.app')
@section('content')

<section class="content-header">
    <h1>ユーザー管理</h1>
</section>

<section class="content container-fluid">
    <div class="row">
        <div class="box">
            <div class="box-body">
                    <p>編集</p>
                    <a href="/admin/users" class="btn btn-default btn-flat pull-right">戻る</a>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <form role="form">
                    <p>ユーザー情報, パスワード}が正しく反映されました</p>
                    <p>エラーが発生しました。</p>
                    <div class="box-bor clearfix">
                        <h4>■ユーザー情報変更</h4>
                        <table class="table">
                            <tbody><tr>
                                <th>名前:</th>
                                <td>
                                    <p class="text-red">ユーザー名は必須です。</p>
                                    <input name="name" id="name" value="{{ $user->name }}" type="text" class="box_inline form-control w30" placeholder="ユーザー1">
                                </td>
                            </tr>
                            <tr>
                                <th>ログインID:</th>
                                <td>
                                    <p class="text-red">ログインIDは必須です。</p>
                                    <input name="loginid" id="loginid" value="{{ $user->loginid }}" type="text" class="box_inline form-control w30" placeholder="user01">
                                </td>
                            </tr>
                            </tbody></table>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-flat pull-right">適用</button>
                        </div>
                    </div>

                    <div class="box-bor clearfix">
                        <h4>■パスワード変更</h4>
                        <table class="table">
                            <tbody><tr>
                                <th>新しいパスワード:</th>
                                <td>
                                    <p class="text-red">パスワードは8文字以上の英数字で入力してください。</p>
                                    <input type="password" class="box_inline form-control w30" placeholder="********">
                                </td>
                            </tr>
                            </tbody></table>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-flat pull-right">適用</button>
                        </div>
                    </div>

                    <div class="box-bor clearfix">
                        <h4>■ユーザーのロック / 解除</h4>
                        <p>ユーザーを削除します。</p>

                        <div class="col-md-12">
                            <div class="pull-right">
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="box-bor clearfix">
                        <h4>■ユーザー削除</h4>
                        <p>ユーザーを削除します。</p>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-danger btn-flat pull-right">削除</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

</section>

@endsection
