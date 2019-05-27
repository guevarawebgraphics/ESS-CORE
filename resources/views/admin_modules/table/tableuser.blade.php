@php
if(Session::get('manage_users') == 'all'){
$add = '';
$edit = '';
$delete = '';
}
elseif(Session::get('manage_users') == 'view'){
$add = 'disabled';
$edit = 'disabled';
$delete = 'disabled';
}
elseif(Session::get('manage_users') == 'add'){
$add = '';
$edit = 'disabled';
$delete = 'disabled';
}
elseif(Session::get('manage_users') == 'edit'){
$add = '';
$edit = '';
$delete = 'disabled';
}
elseif(Session::get('manage_users') == 'delete'){
$add = '';
$edit = 'disabled';
$delete = '';
}else{
$add = 'disabled';
$edit = 'disabled';
$delete = 'disabled';
}
@endphp
<table class="table table-bordered table-striped" id="users_table">
    <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">User ID / ESS ID</th>
            <th scope="col">User Type Access</th>
            <th scope="col">Account Status</th>
            <th scope="col">Change Status</th>
            <th scope="col">Reset Password</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($users) > 0)
        @foreach($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->username}}</td>
            <td>{{$user->type_name}}</td>
            <td>
                @if($user->AccountStatus == 1)
                    <span class="badge badge-success">Active</span>
                @endif
                @if($user->AccountStatus == 2)
                    <span class="badge badge-secondary">In-Active</span>
                @endif
                @if($user->AccountStatus == 3)
                    <span class="badge badge-danger">Deactivated</span>
                @endif
                @if($user->AccountStatus == 0)
                    <span class="badge badge-danger">Deleted</span>
                @endif
            </td>
            
            @if($user->user_type_id == 1)
            <td><button class="CS btn btn-sm btn-info" id="change_status" data-id="{{$user->id}}" disabled>Change Status</button></td>
            <td>
                <button class="btn btn-sm btn-primary" id="reset_password"
                    data-add="{{$user->id}}]]{{$user->name}}]]{{$user->username}}]]{{$user->user_type_id}}" disabled><i
                        class="fa fa-edit"></i> Reset Password</button>
            </td>
            <td>
                <button class="btn btn-sm btn-primary" id="edit_user"
                    data-add="{{$user->id}}]]{{$user->name}}]]{{$user->username}}]]{{$user->user_type_id}}" disabled><i
                        class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-sm btn-danger" id="delete_user" data-add="{{$user->id}}]]{{$user->name}}"
                    disabled><i class="fa fa-trash"></i> Delete</button>
            </td>
            @else
            <td><button class="CS btn btn-sm btn-info" id="change_status" data-id="{{$user->id}}">Change Status</button></td>
            <td>
                <button class="btn btn-sm btn-info" id="reset_password"
                    data-add="{{$user->id}}]]{{$user->name}}]]{{$user->username}}]]{{$user->user_type_id}}" {{$edit}}><i
                        class="fa fa-edit"></i> Reset Password</button>
            </td>
            <td>
                <button class="btn btn-sm btn-primary" id="edit_user"
                    data-add="{{$user->id}}]]{{$user->name}}]]{{$user->username}}]]{{$user->user_type_id}}]]{{$user->employer_id}}" {{$edit}}><i
                        class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-sm btn-danger" id="delete_user" data-add="{{$user->id}}]]{{$user->name}}"
                    {{$delete}}><i class="fa fa-trash"></i> Delete</button>

                
            </td>
            @endif

        </tr>
        @endforeach
        @endif
    </tbody>
</table>