<table class="table table-bordered">
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
                <td>
                    HAKDOG
                </td>               
            </tr>    
            @endforeach
        @endif          
    </tbody>
</table>