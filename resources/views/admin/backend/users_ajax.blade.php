<div class="box-header">
    <div class="col-lg-10">
        <p><span>{{$paging['from']}} 件目～{{$paging['to']}}件目</span> <span>計: {{$paging['total']}}件</span></p>
    </div>
    <div class="col-lg-2" style="text-align:center;">
        {{$users->links()}}
    </div>
</div>
<!-- /.box-header -->
<div class="box-body table-responsive no-padding">
    <table class="table table-hover ">
        <tbody class="users" style="position: relative;">
            <tr>
                <th>id</th>
                <th>名前</th>
                <th>ログインID</th>
                <th>ロック</th>
                <th>作成日時</th>
            </tr>
            @foreach ($users as $user)
            <tr class="user_{{ $user->id }}" data-id='{{ $user->id }}' data-token='<?= md5($user->id . 'editUser' . csrf_token()) ?>' onclick="edit(this);" style="cursor: pointer;">
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->loginid }}</td>
                <td><?= ($user->locked == 1) ? '<span class="glyphicon glyphicon-lock"></span>' : ''; ?></td>
                <td>{{ $user->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- /.box-body -->
