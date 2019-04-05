<table class="table table-bordered">
    <thead>
        <tr>
        <th scope="col">Module Name</th>
        <th scope="col" colspan="6"></th>                         
        </tr>
    </thead>
    <tbody>
    @if(count($module_name) > 0)
        @foreach($module_name as $mn)
        <tr>
            @php
                $withaccess = "";
                $noaccess = "";
                $add = "";
                $edit = "";
                $delete = "";
                $view = "";

                if($moduleRow[$mn->module_code] == "all")
                {
                    $withaccess = "checked";
                }
                if($moduleRow[$mn->module_code] == "none")
                {
                    $noaccess = "checked";
                }
                if($moduleRow[$mn->module_code] == "view")
                {
                    $add = "checked";
                }
                if($moduleRow[$mn->module_code] == "add")
                {
                    $edit = "checked";
                }
                if($moduleRow[$mn->module_code] == "edit")
                {
                    $delete = "checked";
                }
                if($moduleRow[$mn->module_code] == "delete")
                {
                    $view = "checked";
                }
            @endphp
            
            <td>{{$mn->module_name}}</td>          
            <td><input type="radio" name="{{$mn->module_code}}" value="none" {{$noaccess}}>No Access</td>
            <td><input type="radio" name="{{$mn->module_code}}" value="all" {{$withaccess}}> With Access</td>
            <td><input type="radio" name="{{$mn->module_code}}" value="add" {{$add}}>Can Add</td>
            <td><input type="radio" name="{{$mn->module_code}}" value="edit" {{$edit}}>Can Edit</td>
            <td><input type="radio" name="{{$mn->module_code}}" value="delete" {{$delete}}>Can Delete</td>
            <td><input type="radio" name="{{$mn->module_code}}" value="view" {{$view}}>View Only</td>                                      
        </tr>    
        @endforeach
    @endif              
    </tbody>
</table>
