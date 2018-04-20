@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>マスター管理</h1>
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
                        <p>発信元番号編集</p>
                        <button type="submit" class="btn btn-default btn-flat pull-right">戻る</button>
                    </form>
                </div>
            </div>

            <div class="box">
                <div class="box-body">
                    <form role="form">
                        <p>電話番号, 説明}が正しく反映されました</p>
                        <p>エラーが発生しました</p>
                        <div class="box-bor clearfix">
                            <h4>■発信元番号変更</h4>
                            <table class="table">
                                <tbody><tr>
                                    <th>電話番号:</th>
                                    <td>
                                        <p class="text-red">電話番号は必須です。</p>
                                        <input type="text" class="box_inline form-control w30" value="{{ $sourcePhoneNumber->phone_number }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>説明:</th>
                                    <td>
                                        <p class="text-red">説明は必須です。</p>
                                        <input type="text" class="box_inline form-control w30" placeholder="テキストテキスト" value="{{ $sourcePhoneNumber->description }}">
                                    </td>
                                </tr>
                                </tbody></table>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-flat pull-right">適用</button>
                            </div>
                        </div> <!--end box-bor-->

                        <div class="box-bor clearfix">
                            <h4>■発信元番号削除</h4>
                            <p>発信元番号を削除します。</p>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-danger btn-flat pull-right">削除</button>
                            </div>
                        </div> <!--end box-bor-->

                    </form>
                </div>
                <!-- End Box Body -->
            </div>
            <!-- End Box -->
        </div>

    </section>
@endsection