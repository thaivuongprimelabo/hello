<div class="box-header">
    <p class="box-note"><span>{{ $rowFrom }} 件目～{{ $rowTo }}件目</span> <span>計: {{ $calls->total() }}件</span></p>
    
    <div id="paging-monitoring" class="box-tools">
      {{ $calls->links() }}
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
          <tr data-id="{{ $call['id'] }}" data-token='<?= md5($call->id . 'detail' . csrf_token()) ?>' onclick="return detail(this);">
            @php 
            	$types = config('master.TYPE_NAME');
            @endphp
            <td>{{ $types[$call['type']] }}</td>
            <td>{{ str_limit($call['content'], 20, '') }}</td>
            <td>{{ $call['call_number'] }}</td>
            <td><span class="label @if($call['status'] == 'CANCELED') label-danger @else label-primary @endif" >{{ $call['status'] }}</span></td>
            <td>{{ $call['all_start_time'] }}</td>
          </tr>
          @endforeach
        </tbody>
    </table>
</div>
<!-- /.box-body -->
