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
        <form role="form">

          <div class="col-md-2">
            <div class="form-group">
              <label>通知タイプ</label>
              <select class="form-control">
                <option>option 1</option>
                <option>option 2</option>
                <option>option 3</option>
                <option>option 4</option>
                <option>option 5</option>
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label>発信番号</label>
              <select class="form-control">
                <option>option 1</option>
                <option>option 2</option>
                <option>option 3</option>
                <option>option 4</option>
                <option>option 5</option>
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">
              <label>ステータス</label>
              <select class="form-control">
                <option>option 1</option>
                <option>option 2</option>
                <option>option 3</option>
                <option>option 4</option>
                <option>option 5</option>
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>From</label>
              <select class="form-control">
                <option>2018-04-05</option>
                <option>2018-04-05</option>
              </select>
            </div>
          </div>

          <div class="col-md-3">
            <div class="form-group">
              <label>To</label>
              <select class="form-control">
                <option>2018-09-05</option>
                <option>2018-09-05</option>
              </select>
            </div>
          </div>

          <div class="col-md-12">
            <button type="submit" class="btn btn-primary pull-right">適用</button>
          </div>

        </form>
      </div>
      <!-- End Box Body -->
    </div>

    <!-- Box Body -->
    <div class="box">
      <div class="box-header">
        <p class="box-note"><span>11 件目～20件目</span> <span>計: 35件</span></p>

        <div class="box-tools">
          <ul class="pagination pagination-sm no-margin pull-right">
            <li><a href="#">«</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">»</a></li>
          </ul>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
          <tbody><tr>
            <th>通知タイプ</th>
            <th>音声内容</th>
            <th>発信番号</th>
            <th>ステータス</th>
            <th>発信開始日時</th>
          </tr>
          <tr>
            <td>同報</td>
            <td>〇〇で障害が発生した...</td>
            <td>03-1234-5678</td>
            <td><span class="label label-primary">FINISHED</span></td>
            <td>2018-04-20 12:00:01</td>
          </tr>
          <tr>
            <td>順次</td>
            <td>××で障害が発生した...</td>
            <td>03-1234-5678</td>
            <td><span class="label label-danger">CANCELED</span></td>
            <td>2018-04-18 09:32:21</td>
          </tr>
          <tr>
            <td>同報</td>
            <td>〇〇で障害が発生した...</td>
            <td>03-1234-5678</td>
            <td><span class="label label-primary">FINISHED</span></td>
            <td>2018-04-20 12:00:01</td>
          </tr>
          <tr>
            <td>順次</td>
            <td>××で障害が発生した...</td>
            <td>03-1234-5678</td>
            <td><span class="label label-danger">CANCELED</span></td>
            <td>2018-04-18 09:32:21</td>
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