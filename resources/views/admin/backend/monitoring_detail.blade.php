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
            <p>発信開始日時: {{ $calls['all_start_time'] }}</p>
            <p>発信終了日時: {{ $calls['all_end_time'] }}</p>
            <p>通知タイプ:  @php $typeNames = config('master.TYPE_NAME'); @endphp {{ $typeNames[$calls['type']] }}</p>
            <p>ボタンアクション: {{ $calls['button_action'] }}</p>
            <p>リクエストしたユーザー: {{ $calls['user_id'] }}</p>
            <p>発信番号: {{ $calls['call_number'] }}</p>
            <p>呼び出し時間: {{ $calls['call_time'] }}秒</p>
            <p>リトライ: {{ $calls['retry'] }}回</p>
            <p>現在の試行回: {{ $calls['current_trial'] }}回</p>
            <p>実行状況: {{ $calls['status'] }}</p>
          </div>

          <div class="col-md-6">
            <div class="log-btn">
              <a href="{{ url('admin/monitoring') }}" class="btn btn-default btn-flat">閉じる</a>
              <a href="#!" class="btn btn-success btn-flat">更新</a>
            </div>
            <h4>音声通知内容</h4>
            <p>{{ $calls['content'] }}</p>
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
          <thead>
          	<tr>
                <th>試行回</th>
                <th>順番</th>
                <th>電話番号</th>
                <th>ステータス</th>
                <th>担当</th>
                <th>押下ボタン</th>
                <th>発信開始時間</th>
                <th>発信終了時間</th>
          	</tr>
          </thead>
          <tbody>
              @foreach($phoneDestinations as $item)
              <tr>
                <td>{{ $item['trial'] }}</td>
                <td>{{ $item['order'] }}</td>
                <td>
                	{{ $item['phone_number'] }}
                	<i data-toggle="tooltip" data-placement="bottom" title="twilio call sid: [{{ $item['twilio_call_sid'] }}]" data-animation="false" data-trigger="manual"/>
                </td>
                <td><span class="label {{ $item['status'] == 'CANCELED' ? 'label-danger' : 'label-primary' }}">{{ App\Helpers\Twilio::getStatus($item['status']) }}</span></td>
                <td>{{ $item['assigned'] }}</td>
                <td>{{ $item['push_button'] }}</td>
                <td>{{ $item['start_time'] }}</td>
                <td>{{ $item['end_time'] }}</td>
              </tr>
              @endforeach
          </tbody>
        </tbody></table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- End Box -->
  </div>

</section>
<!-- /.content -->
@endsection
@section('script')
    <script src="/assets/admin/js/custom-script.js"></script>
@endsection