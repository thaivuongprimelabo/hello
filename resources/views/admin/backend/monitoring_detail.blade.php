@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>音声通知詳細</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
    <li class="active">Here</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

  <div class="row">
    
    <div class="box">
      <!-- Box Body -->
      <div class="box-body log-detail01">
        <form role="form">

          <div class="col-md-6">
            <p>発信開始日時: 2018-04-20 12:00:11</p>
            <p>発信終了日時: 2018-04-20 12:12:15</p>
            <p>通知タイプ:  同報</p>
            <p>ボタンアクション: パターンA</p>
            <p>リクエストしたユーザー: hoge</p>
            <p>発信番号: 03-1234-5678</p>
            <p>呼び出し時間: 60秒</p>
            <p>リトライ: 1回</p>
            <p>現在の試行回: 1回</p>
            <p>実行状況: FINISHED</p>
          </div>

          <div class="col-md-6">
            <div class="log-btn">
              <a href="#!" class="btn btn-default btn-flat">閉じる</a>
              <a href="#!" class="btn btn-success btn-flat">更新</a>
            </div>
            <h4>音声通知内容</h4>
            <p>〇〇で障害発生したエスカレーションです。<br>テストメッセージ。テストメッセージ。<br>テストメッセージ。テストメッセージ。テストメッセージ。テストメッセージ。テストメッセージ。テストメッセージ。<br>テストメッセージ。テストメッセージ。</p>
          </div>

        </form>
      </div>
      <!-- End Box Body -->
    </div>

    <!-- Box Body -->
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">通知先</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <tbody><tr>
            <th>試行回</th>
            <th>順番</th>
            <th>電話番号</th>
            <th>ステータス</th>
            <th>担当</th>
            <th>押下ボタン</th>
            <th>発信開始時間</th>
            <th>発信終了時間</th>
          </tr>
          <tr>
            <td>1</td>
            <td>1</td>
            <td>090-1234-5678</td>
            <td><span class="label label-primary">FINISHED</span></td>
            <td>-</td>
            <td>2</td>
            <td>2018-04-20 12:00:13</td>
            <td>2018-04-20 12:08:34</td>
          </tr>
          <tr>
            <td>1</td>
            <td>2</td>
            <td>090-1234-4321</td>
            <td><span class="label label-danger">FINISHED</span></td>
            <td>-</td>
            <td>3</td>
            <td>2018-04-20 12:00:15</td>
            <td>2018-04-20 12:05:10</td>
          </tr>
          <tr>
            <td>1</td>
            <td>1</td>
            <td>090-1234-5678</td>
            <td><span class="label label-primary">FINISHED</span></td>
            <td>-</td>
            <td>2</td>
            <td>2018-04-20 12:00:13</td>
            <td>2018-04-20 12:08:34</td>
          </tr>
          <tr>
            <td>1</td>
            <td>2</td>
            <td>090-1234-4321</td>
            <td><span class="label label-danger">FINISHED</span></td>
            <td>-</td>
            <td>3</td>
            <td>2018-04-20 12:00:15</td>
            <td>2018-04-20 12:05:10</td>
          </tr>
          <tr>
            <td>1</td>
            <td>1</td>
            <td>090-1234-5678</td>
            <td><span class="label label-primary">FINISHED</span></td>
            <td>-</td>
            <td>2</td>
            <td>2018-04-20 12:00:13</td>
            <td>2018-04-20 12:08:34</td>
          </tr>
          <tr>
            <td>1</td>
            <td>2</td>
            <td>090-1234-4321</td>
            <td><span class="label label-danger">FINISHED</span></td>
            <td>-</td>
            <td>3</td>
            <td>2018-04-20 12:00:15</td>
            <td>2018-04-20 12:05:10</td>
          </tr>
        </tbody></table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- End Box -->
  </div>

</section>
<!-- /.content -->
@endsection