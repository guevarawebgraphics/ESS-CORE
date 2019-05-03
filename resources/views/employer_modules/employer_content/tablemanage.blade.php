<table id="EmployerContentTable" class="table table-boredered table-striped">
    <thead>
        <tr>
            {{-- <th>ID</th> --}}
            <th>Content Title</th>
            <th>Content Description</th>
            <th>Content Status</th>
            <th>Send Content</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="showdata">
        @if(count($employer_content) > 0)
            @foreach($employer_content as $content)
                <tr>
                    <td>{{$content->content_title}}</td>
                    <td>{{$content->content_description}}</td>
                    @if($content->content_status == 0)               
                        <td><span class="badge badge-warning">Pending</span></td>
                        <td><a href="#send" class="send btn btn-sm btn-info content-post" data-toggle="modal" data-target="#sendModal" data-add="{{$content->id}}]]{{$content->content_title}}"><i class="fa fa-paper-plane"></i> POST</a></td>               
                        <td>
                            <a href="#edit" class="btn btn-sm btn-secondary content-edit " data-add="{{$content->id}}"><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>
                            <a href="#delete" class="btn btn-sm btn-danger content-delete" data-add="{{$content->id}}]]{{$content->content_title}}"><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>
                        </td>
                    @else
                        <td><span class="badge badge-success">Posted</span></td>
                        <td><a class="send btn btn-sm btn-info content-post disabled" data-toggle="modal" data-target="#sendModal" data-add="{{$content->id}}]]{{$content->content_title}}"><i class="fa fa-paper-plane"></i> POST</a></td>
                        <td>
                            <a href="#edit" class="btn btn-sm btn-secondary content-edit disabled" data-add="{{$content->id}}"><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>
                            <a href="#delete" class="btn btn-sm btn-danger content-delete" data-add="{{$content->id}}]]{{$content->content_title}}"><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>
                        </td>
                    @endif                   
                </tr>
            @endforeach
        @else
        @endif       
    </tbody>
</table>          