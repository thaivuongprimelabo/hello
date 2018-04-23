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
                        <p>[発信元番号]を作成しました。</p>
                        <p>エラーが発生しました。</p>
                        <div class="box-bor clearfix">
                            <h4>■発信元番号</h4>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>電話番号:</th>
                                    <td>
                                        <p class="text-red" id="phone_number-error">電話番号は必須です。</p>
                                        <input name="phone_number" type="text" class="box_inline form-control w30" placeholder="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>ログインID:</th>
                                    <td>
                                        <p class="text-red">説明は必須です。</p>
                                        <input name="description" type="text" class="box_inline form-control w30" placeholder="テキストテキスト" value="">
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

                }

                function validateDescription() {

                }

                $("#confirm").click(function() {
                    if(validatePhoneNumber() && validateDescription()) {
                        $('#fromFrm').submit();
                    }
                });
            });
        </script>
    </section>
@endsection