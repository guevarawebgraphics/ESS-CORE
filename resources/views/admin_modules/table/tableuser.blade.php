<table class="table table-bordered" id="users_table">
    <thead>
        <tr>
        <th scope="col">Name</th>
        <th scope="col">Username</th>       
        <th scope="col">Action</th>        
        </tr>
    </thead>
    <tbody>
        @if(count($users) > 0)
            @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->username}}</td>
                @if($user->ess_id == auth()->user()->ess_id)
                    <td>                   
                        <button class="btn btn-secondary" id="edit_user" data-add="{{$user->id}}]]{{$user->name}}]]{{$user->username}}]]{{$user->user_type_id}}" disabled>Edit</button>
                        <button class="btn btn-danger" id="delete_user" data-add="{{$user->id}}" disabled>Delete</button>    
                    </td>    
                @else
                    <td>                   
                        <button class="btn btn-secondary" id="edit_user" data-add="{{$user->id}}]]{{$user->name}}]]{{$user->username}}]]{{$user->user_type_id}}" >Edit</button>
                        <button class="btn btn-danger" id="delete_user" data-add="{{$user->id}}" >Delete</button>    
                    </td>    
                @endif                         
            </tr>    
            @endforeach
        @endif          
    </tbody>
</table>