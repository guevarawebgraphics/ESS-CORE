<table id="BannerContentTable" class="table table-boredered table-striped">
        <thead>
            <tr>
                {{-- <th>ID</th> --}}
                <th>Title</th>
                <th>Description</th>
                <th>Status</th> 
                <th>Media File</th>
                <th>Send Content</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="showdata">
                @if(count($banner_content) > 0)
                @foreach($banner_content as $content)
                    <tr>
                        <td>{{$content->title_banner}}</td>
                        <td>{!! strip_tags(str_limit($content->description_banner,50))!!}</td>
                        @if($content->banner_status == 0)               
                            <td><span class="badge badge-warning">Pending</span></td> 
                            <td>{!! strip_tags(str_limit($content->media_file_banner,50))!!}</td>
                            <td><a href="#send" class="send btn btn-sm btn-outline-info btn-flat banner-post" data-toggle="modal" data-target="#sendModal" data-add="{{$content->id}}]]{{$content->title_banner}}"><i class="fa fa-paper-plane"></i> POST</a></td>               
                            <td>
                                <a href="#edit" class="btn btn-sm btn-outline-secondary btn-flat banner-edit " data-add="{{$content->id}}" data-toggle="modal" data-target="#AddBannerModal"><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>
                                <a href="#delete" class="btn btn-sm btn-outline-danger btn-flat banner-delete" data-add="{{$content->id}}]]{{$content->title_banner}}"><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>
                            </td>
                        @else
                            <td><span class="badge badge-success">Posted</span></td> 
                            <td>{!! strip_tags(str_limit($content->media_file_banner,50))!!}</td>
                            <td><a class="send btn btn-sm btn-info content-post disabled" data-toggle="modal" data-target="#sendModal" data-add="{{$content->id}}]]{{$content->title_banner}}"><i class="fa fa-paper-plane"></i> POST</a></td>
                            <td>
                                <a href="#edit" class="btn btn-sm btn-outline-secondary btn-flat banner-edit disabled" data-add="{{$content->id}}"><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>
                                <a href="#delete" class="btn btn-sm btn-outline-danger btn-flat banner-delete" data-add="{{$content->id}}]]{{$content->title_banner}}"><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>
                            </td>
                        @endif                   
                    </tr>
                @endforeach
            @else
            @endif   
        </tbody>
    </table>          