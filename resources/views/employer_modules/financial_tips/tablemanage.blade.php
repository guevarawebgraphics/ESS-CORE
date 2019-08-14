<div class="table-responsive">
<table id="FinancialTipsTable" class="table table-boredered table-striped">
        <thead>
            <tr>
                <th>Financial Tips Title</th>
                <th>Financial Tips Description</th>
                <th>Financial Tips Status</th>
                <th>Send</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="showdata"> 
            
            @forelse($FinancialTipsTable as $table)
                <tr>
                    <td>{{$table->financial_tips_title}}</td>
                    <td>{!! strip_tags(str_limit($table->financial_tips_description,50))!!}</td>
                    @if($table->status == 0)               
                    <td><span class="badge badge-warning">Pending</span></td>
                    <td><a href="#send" class="send btn btn-sm btn-outline-info btn-flat financial-tips-post" data-toggle="modal" data-target="#sendModal" data-add="{{$table->id}}"><i class="fa fa-paper-plane"></i> POST</a></td>               
                    <td>
                        <a href="#edit" class="btn btn-sm btn-outline-secondary btn-flat financial-tips-edit" data-add="{{$table->id}}" data-title="{{$table->financial_tips_title}}" data-description="{{$table->financial_tips_description}}" data-toggle="modal" data-target="#ModalFinancialTips"><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>
                        <a href="#delete" class="btn btn-sm btn-outline-danger btn-flat financial-tips-delete" data-add="{{$table->id}}"><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>
                    </td>
                     @else
                    <td><span class="badge badge-success">Posted</span></td>
                    <td><a class="send btn btn-sm btn-info content-post disabled" data-toggle="modal" data-target="#sendModal" data-add=""><i class="fa fa-paper-plane"></i> POST</a></td>
                    <td>
                    <a href="#edit" class="btn btn-sm btn-outline-secondary btn-flat financial-tips-edit disabled" data-add="{{$table->id}}"><span class="icon is-small"><i class="fa fa-edit"></i></span>&nbsp;Edit</a>
                        <a href="#delete" class="btn btn-sm btn-outline-danger btn-flat financial-tips-delete" data-add="{{$table->id}}"><span class="icon is-small"><i class="fa fa-trash"></i></span>&nbsp;Delete</a>
                    </td>
                    @endif    
                </tr>
            @empty 
        


            @endforelse
        </tbody>
    </table>          
</div>