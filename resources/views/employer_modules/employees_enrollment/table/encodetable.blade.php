
<table class="table table-bordered table-striped" id="employee_table">
        <thead>
            <tr>
                <th>Employee No</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Status</th>
                <th>Change Status</th>
                <th>Action</th>                 
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
                    <td>
                        @if($info->AccountStatus == 1)
                            <span class="badge badge-success">Active</span>
                        @endif
                        @if($info->AccountStatus == 2)
                            <span class="badge badge-secondary">In-Active</span>
                        @endif
                        @if($info->AccountStatus == 3)
                            <span class="badge badge-danger">Deactivated</span>
                        @endif
                        @if($info->AccountStatus == 0)
                            <span class="badge badge-danger">Deleted</span>
                        @endif
                    </td>
                    <td>
                        <button class="CS btn btn-sm btn-info btn-outline-info btn-flat" id="change_status" data-id="{{$info->emp_id}}">Change Status</button>
                    </td>
                    <td>
                        <a href="/enrollemployee/edit/{{$info->id}}" class="btn btn-sm btn-primary btn-outline-primary btn-flat" id="btn_editemployee">Edit Employee</a>
                    </td>
                </tr>
                @endforeach
            @else
            @endif
        </tbody>
    </table>       