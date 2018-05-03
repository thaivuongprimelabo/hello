<div class="box-header">
    <p class="box-note"><span>{{ $paging['from'] }} 件目～{{ $paging['to'] }}件目</span> <span>計: {{ $paging['total'] }}件</span></p>
    
    <div id="paging-monitoring" class="box-tools">
      {{ $calls->links('vendor.pagination.paging', ['paging' => $paging]) }}
    </div>
</div>
<!-- /.box-header -->
<div class="box-body table-responsive no-padding">
    <table id="listLog" class="table table-hover">
      <thead>
          <tr>
            <th>通知タイプ</th>
            <th>音声内容</th>
            <th>発信番号</th>
            <th>ステータス</th>
            <th>発信開始日時</th>
          </tr>
        </thead>
        <tbody>
          @foreach($calls as $call)
          <tr data-id="{{ $call['id'] }}" data-token='<?= md5($call->id . 'detail' . csrf_token()) ?>' onclick="return detail(this);" style="cursor: pointer;">
            <td>{{ App\Helpers\Twilio::getTypes(!empty($call['type']) ? $call['type'] : '1', Config::get('app.locale')) }}</td>
            <td>{{ App\Helpers\Twilio::subStringBreakline($call['content'], 0, config('master.CONTENT_LENGTH')) }}</td>
            <td>{{ $call['call_number'] }}</td>
            <td><span class="label @if($call['status'] == 'CANCELED') label-danger @else label-primary @endif" >{{ App\Helpers\Twilio::getStatus(!empty($call['status']) ? $call['status'] : '1', Config::get('app.locale')) }}</span></td>
            <td>{{ $call['all_start_time'] }}</td>
          </tr>
          @endforeach
        </tbody>
    </table>
</div>
<!-- /.box-body -->
