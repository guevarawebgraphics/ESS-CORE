<table class="table table-bordered table-striped" id="usertype_table">
    <thead>
        <tr>
        <th scope="col">User Type Name</th>
        <th scope="col">User Type Description</th>
        <th scope="col">Action</th>        
        </tr>
    </thead>
    <tbody>
        @if(count($user_type) > 0)
            @foreach($user_type as $user)
            <tr>
                <td>{{$user->type_name}}</td>
                <td>{{$user->type_description}}</td>
                @if($user->created_by == "default")
                    <td>
                        <button class="btn btn-sm btn-secondary" id="edit_usertype" data-add="{{$user->id}}]]{{$user->type_name}}]]{{$user->type_description}}" disabled>Edit</button>
                        <button type="button" class="btn btn-sm btn-primary" id="manage" data-add="{{$user->id}}" disabled>Manage Access</button>
                        <button class="btn btn-sm btn-danger" id="delete_usertype" data-add="{{$user->id}}]]{{$user->type_name}}" disabled>Delete</button>                       
                    </td>
                @else
                    <td>
                        <button class="btn btn-sm btn-secondary" id="edit_usertype" data-add="{{$user->id}}]]{{$user->type_name}}]]{{$user->type_description}}" {{$edit}}>Edit</button>
                        <button type="button" class="btn btn-sm btn-primary" id="manage" data-add="{{$user->id}}" {{$edit}}>Manage Access</button>
                        <button class="btn btn-sm btn-danger" id="delete_usertype" data-add="{{$user->id}}]]{{$user->type_name}}" {{$delete}}>Delete</button>                       
                    </td>
                @endif
            </tr>    
            @endforeach
        @endif          
    </tbody>
</table>