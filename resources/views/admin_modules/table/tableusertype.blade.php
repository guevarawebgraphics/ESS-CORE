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
<table class="table table-bordered table-striped" id="usertype_table">
    <thead>
        <tr>
        <th scope="col">User Type Name</th>
        <th scope="col">User Type Description</th>
        <th scope="col">Manage User Access</th>
        <th scope="col">Action</th>        
        </tr>
    </thead>
    <tbody>
        @if(count($user_type) > 0)
            @foreach($user_type as $user_types)
            <tr>
                <td>{{$user_types->type_name}}</td>
                <td>{{$user_types->type_description}}</td>
                @if($user_types->created_by == "default")
                    <td>                      
                        <button type="button" class="btn btn-sm btn-outline-primary btn-flat" id="manage" data-add="{{$user_types->id}}" disabled><i class="fa fa-info"></i> Manage Access</button>                            
                    </td>
                @else
                    <td>                      
                        <button type="button" class="btn btn-sm btn-outline-primary btn-flat" id="manage" data-add="{{$user_types->id}}||{{$user_types->type_name}}" {{$edit}}><i class="fa fa-info"></i> Manage Access</button>               
                    </td>
                @endif
                @if($user_types->created_by == "default")
                    <td>
                        <button class="btn btn-sm btn-outline-info btn-flat" id="edit_usertype" data-add="{{$user_types->id}}]]{{$user_types->type_name}}]]{{$user_types->type_description}}" disabled><i class="fa fa-edit"></i> Edit</button>
                        <button class="btn btn-sm btn-outline-danger btn-flat" id="delete_usertype" data-add="{{$user_types->id}}]]{{$user_types->type_name}}" disabled><i class="fa fa-trash"></i> Delete</button>                       
                    </td>
                @else
                    <td>
                        <button class="btn btn-sm btn-outline-info btn-flat" id="edit_usertype" data-add="{{$user_types->id}}]]{{$user_types->type_name}}]]{{$user_types->type_description}}" {{$edit}}><i class="fa fa-edit"></i>Edit</button>
                        <button class="btn btn-sm btn-outline-danger btn-flat" id="delete_usertype" data-add="{{$user_types->id}}]]{{$user_types->type_name}}" {{$delete}}><i class="fa fa-trash"></i> Delete</button>                       
                    </td>
                @endif
            </tr>    
            @endforeach
        @endif          
    </tbody>
</table>