<table class="table table-bordered table-striped" id="employee_table">
    <thead>
        <tr>
            <th scope="col">Employee No</th>
            <th scope="col">Employee Name</th>
            <th scope="col">Department</th>
            <th scope="col">Position</th>
            <th scope="col">Status</th>
            <th scope="col" colspan="2">Action</th>                 
        </tr>
    </thead>
    <tbody>
        @if(count($employee_info) > 0)
            @foreach($employee_info as $info)
            <tr>
                <td>{{$info->employee_no}}</td>
                <td>{{ucfirst($info->lastname) . ", " . ucfirst($info->firstname) . " " . ucfirst($info->middlename)}}</td>
                <td>{{ucfirst($info->department)}}</td>
                <td>{{ucfirst($info->position)}}</td>
                <td><span class="badge badge-success">Active</span></td>
                <td>
                    <a href="/enrollemployee/edit/{{$info->id}}" class="btn btn-sm btn-primary" id="btn_editemployee">Edit Employee</a>
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-info" id="btn_changestatus">Change Status</a>                    
                </td>
            </tr>
            @endforeach
        @else
        @endif
    </tbody>
</table>       