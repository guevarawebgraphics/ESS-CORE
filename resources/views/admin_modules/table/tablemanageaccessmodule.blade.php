<table class="table table-bordered table-striped" id="moduleaccess_table">
    <thead>
        <tr>
            <th scope="col">Module Name</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>                    
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
                if($moduleRow[$mn->module_code] == "add")
                {
                    $add = "checked";
                }
                if($moduleRow[$mn->module_code] == "edit")
                {
                    $edit = "checked";
                }
                if($moduleRow[$mn->module_code] == "delete")
                {
                    $delete = "checked";
                }
                if($moduleRow[$mn->module_code] == "view")
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
    @else
    <tr>
            <td scope="col">SAS</td>
            <td scope="col" colspan="6"></td>                         
        </tr>
    @endif              
    </tbody>
</table>
<script>
$(document).ready(function(){

    $("#moduleaccess_table").dataTable({
        "ordering": false,
        "pageLength": 25
    });
})
</script>
