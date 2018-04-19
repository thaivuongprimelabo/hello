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