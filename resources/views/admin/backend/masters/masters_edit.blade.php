@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>マスター管理</h1>
        <ol class="breadcrumb">
            <li><a href="{{Route('dashboard')}}"><i class="fa fa-dashboard"></i>{{Config::get('master.Home_Title')}}</a></li>
            <li class="active">Masters</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="row">
            <div class="box">
                <div class="box-body">
                        <p>発信元番号編集</p>
                        <a href="/admin/masters" class="btn btn-default btn-flat pull-right">戻る</a>
                </div>
            </div>

            <div class="box">
                <div class="box-body">
                    {{--<p>電話番号, 説明}が正しく反映されました</p>--}}
                    {{--<p>エラーが発生しました</p>--}}
                    @if(!empty($message))
                        @if($message['success'])
                            <div class="alert alert-success"> {{ $message['message'] }} </div>
                        @else
                            <div class="alert alert-danger"> {{ $message['message'] }} </div>
                        @endif
                    @endif

                    <div class="box-bor clearfix">
                        <form method="post" id="infoForm">
                            {{ csrf_field() }}
                            <h4>■発信元番号変更</h4>
                            <input name="edittype" value="editinfo" type="hidden">
                            <table class="table">
                                <tbody><tr>
                                    <th>電話番号:</th>
                                    <td>
                                        <p class="text-red" id="phone_number_error"></p>
                                        <input type="text" id="phone_number" name="phone_number" class="box_inline form-control w30" value="{{ $sourcePhoneNumber->phone_number }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>説明:</th>
                                    <td>
                                        <p class="text-red" id="description_error"></p>
                                        <input type="text" id="description" name="description" class="box_inline form-control w30" placeholder="テキストテキスト" value="{{ $sourcePhoneNumber->description }}">
                                    </td>
                                </tr>
                                </tbody></table>

                            <div class="col-md-12">
                                <button id="confirm" type="button" class="btn btn-primary btn-flat pull-right">適用</button>
                            </div>
                        </form>
                    </div>

                    <div class="box-bor clearfix">
                        <h4>■発信元番号削除</h4>
                        <p>発信元番号を削除します。</p>

                        <div class="col-md-12">
                            <form method="post" id="dellForm">
                                {{ csrf_field() }}
                                <input name="edittype" value="dell_phone_number" type="hidden">
                                <button id="comfirmDelete" type="button" class="btn btn-danger btn-flat pull-right">削除</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                function validatePhoneNumber() {
                    $('#phone_number_error').html('');
                    var phone_number = $('#phone_number').val();

                    if($.trim(phone_number) == '') {
                        $('#phone_number_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_013');?>');
                        return false;
                    }

                    if(phone_number.length >= 255) {
                        $('#phone_number_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_004');?>');
                        return false;
                    }

                    var regex = /^(\d+-?)+\d+$/;
                    if (!regex.test(phone_number))
                    {
                        $('#phone_number_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_005');?>');
                        return false;
                    }

                    return true;
                }

                function validateDescription() {
                    $('#description_error').html('');
                    var description = $('#description').val();

                    if($.trim(description) == '') {
                        $('#description_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_014');?>');
                        return false;
                    }

                    if(description.length >= 255) {
                        $('#description_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_004');?>');
                        return false;
                    }

                    return true;
                }

                $("#confirm").click(function() {
                    if($('#phone_number').val().trim() != '{{ $sourcePhoneNumber->phone_number }}') {
                        $.ajax({
                            type: 'post',
                            url: '{{route("masters_count_phone_number")}}',
                            data: {'phone_number': $('#phone_number').val().trim()},
                            dataType: "json",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function (result) {
                                if (result.count > 0) {
                                    $('#phone_number_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_015');?>');
                                    validateDescription();
                                }
                                else {
                                    // validate rules
                                    var phoneNumber = validatePhoneNumber();
                                    var description = validateDescription();

                                    if(phoneNumber && description) {
                                        $('#infoForm').submit();
                                    }
                                }
                            }
                        });
                    }
                    else {
                        var phoneNumber = validatePhoneNumber();
                        var description = validateDescription();

                        if(phoneNumber && description) {
                            $('#infoForm').submit();
                        }
                    }

                });

                $('#comfirmDelete').click(function(){
                    var r = confirm("{{ config('master.MESSAGE_NOTIFICATION.MSG_017') }}");
                    if(r == true) {
                        $('#dellForm').submit();
                    }
                });
            });
        </script>
    </section>
@endsection