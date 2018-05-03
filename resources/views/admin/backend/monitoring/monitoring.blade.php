@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>音声通知履歴</h1>
  <ol class="breadcrumb">
    <li><a href="{{Route('dashboard')}}"><i class="fa fa-dashboard"></i>{{Config::get('master.Home_Title')}}</a></li>
    <li class="active">Monitoring</li>
  </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">

  <div class="row">
    
    <div class="box">
      <!-- Box Body -->
      <div class="box-body">
          <div class="col-md-2">
            <div class="form-group">
              <label>通知タイプ</label>
              <select class="form-control" name="type" id="type">
              	<option value="">{{ config('master.EMPTY_ITEM') }}</option>
              	<option value="{{ config('master.TYPE.SAME_TIME') }}" {{ isset($type) && $type == config('master.TYPE.SAME_TIME') ? 'selected=selected' : '' }} >{{ App\Helpers\Twilio::getTypes(config('master.TYPE.SAME_TIME'), Config::get('app.locale')) }}</option>
              	<option value="{{ config('master.TYPE.ORDER') }}" {{ isset($type) && $type == config('master.TYPE.ORDER') ? 'selected=selected' : '' }} >{{ App\Helpers\Twilio::getTypes(config('master.TYPE.ORDER'), Config::get('app.locale')) }}</option>
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>発信番号</label>
              <select class="form-control" name="call_number" id="call_number">
                <option value="">{{ config('master.EMPTY_ITEM') }}</option>
                @foreach($source_phone_numbers as $number)
                <option value="{{ $number['phone_number'] }}" {{ isset($call_number) && $call_number == $number['phone_number'] ? 'selected=selected' : '' }} >{{ $number['phone_number']  }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>ステータス</label>
              <select class="form-control" name="status" id="status">
              <option value="">{{ config('master.EMPTY_ITEM') }}</option>
                <option value="{{ config('master.TWILIO_STATUS.CALLING') }}" {{ isset($status) && $status == config('master.TWILIO_STATUS.CALLING') ? 'selected=selected' : '' }}>{{ App\Helpers\Twilio::getStatus(config('master.TWILIO_STATUS.CALLING'), Config::get('app.locale')) }}</option>
              	<option value="{{ config('master.TWILIO_STATUS.FINISHED') }}" {{ isset($status) && $status == config('master.TWILIO_STATUS.FINISHED') ? 'selected=selected' : '' }}>{{ App\Helpers\Twilio::getStatus(config('master.TWILIO_STATUS.FINISHED'), Config::get('app.locale')) }}</option>
              	<option value="{{ config('master.TWILIO_STATUS.CANCELED') }}" {{ isset($status) && $status == config('master.TWILIO_STATUS.CANCELED') ? 'selected=selected' : '' }}>{{ App\Helpers\Twilio::getStatus(config('master.TWILIO_STATUS.CANCELED'), Config::get('app.locale')) }}</option>
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label>From</label>
              	<div id="datetimepicker-from" class="date">
                	<input type="text" class="form-control" value="{{ $dateFrom }}" name="datefrom" id="datefrom" />
                </div>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label>To</label>
              <div id="datetimepicker-to" class="date">
            		<input type="text" class="form-control" value="{{ $dateTo }}" name="dateto" id="dateto" />
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <button type="submit" id="search" class="btn btn-primary pull-right">検索</button>
          </div>
      </div>
      <!-- End Box Body -->
    </div>

    <!-- Box Body -->
    <div id="logBox" class="box">
      @include('admin.backend.monitoring.monitoring_ajax')
    </div>
    <!-- End Box -->
  </div>

</section>

<!-- /.content -->
@endsection
@section('script')
    <script src="/assets/admin/js/custom-script.js"></script>
@endsection
