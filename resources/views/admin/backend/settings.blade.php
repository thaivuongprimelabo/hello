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
        <form role="form" method="post">
		  {{ csrf_field() }}
          <p>設定が正しく反映されました。</p>

          <p>エラーが発生しました。</p>
          
          <div class="box-row">
              <div class="box-w80">
                    <p class="text-center text-red">0～3の整数で入力してください。</p>
                    <p>
                        <label class="mr10">デフォルトリトライ回数</label>
                        <input type="text" class="box_inline form-control w70" placeholder="0" name="retry" value="{{ isset($output[config('master.KEYS.DEFAULT_RETRY')]) ? $output[config('master.KEYS.DEFAULT_RETRY')] : 0 }}">
                    </p>
              </div>
          </div>
          
          <div class="box-row">
               <div class="box-w80">
                    <p class="text-center text-red">0～120の整数で入力してください。</p>
                    <div class="">
                        <label class="mr10">デフォルト呼び出し時間</label>
                        <input type="text" class="box_inline form-control w70" placeholder="60" name="call_time" value="{{ isset($output[config('master.KEYS.DEFAULT_CALL_TIME')]) ? $output[config('master.KEYS.DEFAULT_CALL_TIME')] : 0 }}">
                    </div>
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