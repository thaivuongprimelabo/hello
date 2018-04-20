@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1>マスター管理</h1>
        <ol class="breadcrumb">
            <li><a href="{{Route('dashboard')}}"><i class="fa fa-dashboard"></i>{{Config::get('master.Home_Title')}}</a></li>
            <li class="active">Masters</li>
        </ol>
    </section>

    <section class="content container-fluid">
        <div class="row">
            <div class="box">
                <div class="box-body">
                    <form role="form">
                        <p>新しく発信元番号を追加する場合は以下のボタンを押してください。</p>
                        <button type="submit" class="btn btn-primary btn-flat">発信元追加</button>
                    </form>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <p class="box-note"><span>11 件目～20件目</span> <span>計: 35件</span></p>

                    <div class="box-tools">
                            {!! $sourcePhoneNumber->links() !!}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>id</th>
                            <th>電話番号</th>
                            <th>説明</th>
                            <th>作成日時</th>
                        </tr>
                        @foreach($sourcePhoneNumber as $row)
                            <tr class="phone-row" data-text="{{ $row->id }}">
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->phone_number }}</td>
                                <td>{{ $row->description }}</td>
                                <td>{{ $row->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.phone-row').click(function(){
                console.log();
                window.location.href = 'masters/edit/'+$(this).attr('data-text');
            })
        });
    </script>
@endsection