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
                    <p>発信元番号新規作成</p>
                    <p>新たに発信元番号を作成します。</p>
                    <a href="/admin/masters" class="btn btn-default btn-flat pull-right">戻る</a>
                </div>
            </div>

            <div class="box">
                <div class="box-body">
                    <form method="POST" id="fromFrm">
                        {{ csrf_field() }}
                        {{--<p>[発信元番号]を作成しました。</p>--}}
                        {{--<p>エラーが発生しました。</p>--}}
                        @if(!empty($message))
                            @if($message['success'])
                                <div class="alert alert-success"> {{ $message['message'] }} </div>
                            @else
                                <div class="alert alert-danger"> {{ $message['message'] }} </div>
                            @endif
                        @endif

                        <div class="box-bor clearfix">
                            <h4>■発信元番号</h4>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>電話番号:</th>
                                    <td>
                                        <p class="text-red" id="phone_number_error"></p>
                                        <input name="phone_number" id="phone_number" type="text" class="box_inline form-control w30" placeholder="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>説明</th>
                                    <td>
                                        <p class="text-red" id="description_error"></p>
                                        <input name="description" id="description" type="text" class="box_inline form-control w30" placeholder="テキストテキスト" value="">
                                    </td>
                                </tr>
                                </tbody></table>

                            <div class="col-md-12">
                                <button type="button" id="confirm" class="btn btn-primary btn-flat pull-right">作成</button>
                            </div>
                        </div>
                    </form>
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

                    return true;
                }

                $("#confirm").click(function() {
                    $.ajax({
                        type: 'post',
                        url: '{{route("masters_count_phone_number")}}',
                        data: {'phone_number': $('#phone_number').val().trim()},
                        dataType: "json",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (result) {
                            if (result.count > 0) {
                                console.log('vao');
                                $('#phone_number_error').html( '<?= config('master.MESSAGE_NOTIFICATION.MSG_015');?>');
                                validateDescription();
                            }
                            else {
                                // validate rules
                                var phoneNumber = validatePhoneNumber();
                                var description = validateDescription();

                                if(phoneNumber && description) {
                                    $('#fromFrm').submit();
                                }
                            }
                        }
                    });

                });
            });
        </script>
    </section>
@endsection