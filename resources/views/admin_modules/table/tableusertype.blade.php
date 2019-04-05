<table class="table table-bordered">
    <thead>
        <tr>
        <th scope="col">User Type Name</th>
        <th scope="col">User Type Description</th>
        <th scope="col">Access</th>
        <th scope="col">Action</th>        
        </tr>
    </thead>
    <tbody>
        @if(count($user_type) > 0)
            @foreach($user_type as $user)
            <tr>
                <td>{{$user->type_name}}</td>
                <td>{{$user->type_description}}</td>
                <td>
                    <button type="button" class="btn btn-primary" id="manage" data-add="{{$user->id}}" >Manage Access</button>
                </td>
                <td>
                    <button class="btn btn-secondary" id="edit" data-add="{{$user->id}}" >Edit</button>
                    <button class="btn btn-danger" id="delete" data-add="{{$user->id}}" >Delete</button>                       
                </td>
            </tr>    
            @endforeach
        @endif          
    </tbody>
</table>