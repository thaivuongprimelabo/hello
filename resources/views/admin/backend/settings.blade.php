@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>設定管理</h1>
  <ol class="breadcrumb">
    <li><a href="{{Route('dashboard')}}"><i class="fa fa-dashboard"></i>{{Config::get('master.Home_Title')}}</a></li>
    <li class="active">Settings</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

  <div class="row">
    <div class="box">
      <!-- Box Body -->
      <div class="box-body">
      	@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form id="frmForm" role="form" method="post">
		  {{ csrf_field() }}
          <p>設定が正しく反映されました。</p>

          <p>エラーが発生しました。</p>
          
          <div class="box-row">
              <div class="box-w80">
                    <p class="text-center text-red">{{ $errors->first('retry') }}</p>
                    <p>
                        <label class="mr10">デフォルトリトライ回数</label>
                        <input type="text" class="box_inline form-control w70" placeholder="0" maxlength="1" name="retry" value="{{ $errors->has('retry') ? old('retry') : $output[config('master.KEYS.DEFAULT_RETRY')] }}" id="retry" required>
                    </p>
              </div>
          </div>
          
          <div class="box-row">
               <div class="box-w80">
                    <p class="text-center text-red">{{ $errors->first('call_time') }}</p>
                    <p>
                        <label class="mr10">デフォルト呼び出し時間</label>
                        <input type="text" class="box_inline form-control w70" placeholder="60" maxlength="3" name="call_time" value="{{ $errors->has('call_time') ? old('call_time') : $output[config('master.KEYS.DEFAULT_CALL_TIME')] }}" id="call_time" required>
                    </p>
              </div>
          </div>
          
          <p class="text-red">TODO: 設定項目他にないか確認 </p>

          <div class="col-md-12">
            <button type="submit" class="btn btn-success btn-flat pull-right">適用</button>
          </div>

        </form>
      </div>
      <!-- End Box Body -->
    </div>
  </div>

</section>
<!-- /.content -->
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function () {
	$("#frmForm").validate({
		onfocusout: false,
		rules: {
			retry: {
				required: true,
				digits:true,
				range: [0,3]
			},
			call_time: {
				required: true,
				digits:true,
				range: [0,120]
			}
		},
		messages: {
			retry : {
				required	:'0～3の整数で入力してください。',
				digits		:'0～3の整数で入力してください。',
				range		:'0～3の整数で入力してください。'
			},
			call_time : {
				required	:'0～120の整数で入力してください。',
				digits		:'0～120の整数で入力してください。',
				range		:'0～120の整数で入力してください。'
			}
		},
		errorPlacement: function(error, element) {
	    	error.appendTo( element.parent("p").prev("p") );
	  	}
	});
});
</script>
@endsection