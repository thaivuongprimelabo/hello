@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>ログ閲覧</h1>
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
      <div class="box-body">
          <div class="col-md-2">
            <div class="form-group">
              <label>通知タイプ</label>
              <select class="form-control" name="type" id="type">
              	<option value="">{{ config('master.EMPTY_ITEM') }}</option>
              	@php
              		$type_names = config('master.TYPE_NAME');
              	@endphp
                @foreach($types as $item)
                <option value="{{ $item['type'] }}" {{ $item['type'] == $select_type ? 'selected=selected' : '' }}>{{ $type_names[$item['type']] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label>発信番号</label>
              <select class="form-control" name="call_number" id="call_number">
                <option value="">{{ config('master.EMPTY_ITEM') }}</option>
                @foreach($source_phone_numbers as $number)
                <option value="{{ $number['phone_number'] }}" {{ $number['phone_number'] == $select_call ? 'selected=selected' : '' }}">{{ $number['phone_number']  }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label>ステータス</label>
              <select class="form-control" name="status" id="status">
              <option value="">{{ config('master.EMPTY_ITEM') }}</option>
                @foreach($status as $item)
                <option value="{{ $item['status'] }}" {{ $item['status'] == $select_status ? 'selected=selected' : '' }}">{{ $item['status'] }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>From</label>
              	<div id="datetimepicker-from" class="date">
                	<input type="text" class="form-control" value="{{ $dateFrom }}" name="datefrom" id="datefrom" />
                </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>To</label>
              <div id="datetimepicker-to" class="date">
            		<input type="text" class="form-control" value="{{ $dateTo }}" name="dateto" id="dateto" />
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <button type="submit" id="search" class="btn btn-primary pull-right">適用</button>
          </div>
      </div>
      <!-- End Box Body -->
    </div>

    <!-- Box Body -->
    <div id="logBox" class="box">
      @include('admin.backend.monitoring_ajax')
    </div>
    <!-- End Box -->
  </div>

</section>

<!-- /.content -->
@endsection
