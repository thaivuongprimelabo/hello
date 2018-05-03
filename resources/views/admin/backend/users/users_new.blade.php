@extends('layouts.app')
@section('content')

<section class="content-header">
    <h1>ユーザー管理</h1>
</section>

<section class="content container-fluid">
    <div class="row">
        <div class="box">
            <div class="box-body">
                    <p>新規作成</p>
                    <p>新たにユーザーを作成します。</p>
                    <a href="/admin/users" class="btn btn-default btn-flat pull-right">戻る</a>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <form method="POST" id="formFrm">
                    {{ csrf_field() }}
                    {{--<p>[ユーザー名]を作成しました。</p>--}}
                    {{--<p>エラーが発生しました。</p>--}}
                    <?php if(!empty($message)):?>
                        <?php if($message['success']):?>
                            <div class="alert alert-success"> {{ $message['message'] }} </div>
                        <?php else:?>
                            <div class="alert alert-danger"> {{ $message['message'] }} </div>
                        <?php endif?>
                    <?php endif?>
                    <div class="box-bor clearfix">
                        <h4>■ユーザー情報</h4>
                        <table class="table">
                            <tbody><tr>
                                <th>名前:</th>
                                <td>
                                    <p class="text-red" id="name_error"></p>
                                    <input id="name" name="name" type="text" class="box_inline form-control w30" placeholder="ユーザー1">
                                </td>
                            </tr>
                            <tr>
                                <th>ログインID:</th>
                                <td>
                                    <p class="text-red" id="loginid_error"></p>
                                    <input id="loginid" name="loginid" type="text" class="box_inline form-control w30" placeholder="user01">
                                </td>
                            </tr>
                            <tr>
                                <th>パスワード:</th>
                                <td>
                                    <p class="text-red" id="password_error"></p>
                                    <input id="password" name="password" type="password" class="box_inline form-control w30" placeholder="********">
                                </td>
                            </tr>
                            </tbody></table>

                        <div class="col-md-12">
                            <button id="confirm" type="button" class="btn btn-primary btn-flat pull-right">作成</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            function validateName() {
                $('#name_error').html("");
                if($.trim($('#name').val()) == ''){
                    $('#name_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_006');?>');
                    return false;
                }
                if($('#name').val().length >= 255) {
                    $('#name_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_004');?>');
                    return false;
                }

                return true;
            }

            function validateLoginid() {
                $('#loginid_error').html('');
                var loginid = $('#loginid').val();

                if($.trim(loginid) == ''){
                    $('#loginid_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_007');?>');
                    return false;
                }

                if(loginid.length >= 255) {
                    $('#loginid_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_004');?>');
                    return false;
                }

                var regex = /^[a-z0-9]+$/i;
                if (!regex.test(loginid))
                {
                    $('#loginid_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_009');?>');
                    return false;
                }

                return true;
            }

            function validatePassword() {
                $('#password_error').html('');
                var password = $('#password').val();
                if($.trim(password) == ''){
                    $('#password_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_008');?>');
                    return false;
                }

                if(password.length >= 255) {
                    $('#password_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_004');?>');
                    return false;
                }

                var regex = /^[A-Za-z0-9\d=!"#$%&'()*+,-./:;<=>?@\[\]\^_`{}|~]{8,}$/;
                if (!regex.test(password))
                {
                    $('#password_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_008');?>');
                    return false;
                }

                return true;
            }

            $("#confirm").click(function() {
                // check loginID already exist
                $.ajax({
                    type: 'post',
                    url: '{{route("users_cound_loginid")}}',
                    data: {'loginid': $('#loginid').val().trim()},
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (result) {
                        if (result.count > 0) {
                            $('#loginid_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_010');?>');
                        }
                        else {
                            // validate rules
                            var valName = validateName();
                            var valLoginId = validateLoginid();
                            var valPass = validatePassword();
                            if( valName && valLoginId && valPass) {
                                $('#formFrm').submit();
                            }
                        }
                    }
                });
            });
        });
    </script>
</section>

@endsection
