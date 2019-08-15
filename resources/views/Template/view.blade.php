@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Docs & Template</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Docs & Template</a>
            </li>
            <li class="breadcrumb-item active-DocsTemplate text-secondary">Index</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
            <center><strong>Docs & Template</strong></center>
        </div>
        <div class="card-body">
                <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="fa fa-search input-group-text" style="background-color: #fff;"></span>
                          </div>
                          <input id="searchbox" type="text" class="form-control" name="searchbox" placeholder="Search">
                      </div>
                <table id="DocumentAndTemplate" class="table table-boredered table-striped">
                        <thead>
                            <tr>
                                {{-- <th>ID</th> --}}
                         
                                <th>Template Name</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody id="showdata">
                            {{-- Showdata --}}  
                            @foreach($Templates as $template)
                            <tr>
                            <td> {{$template->document_code}}</td>
                            <td data-toggle="tooltip" data-placement="top" title="Click To Download This Template"><a href="/storage/Documents/templates/{{$template->document_file}}" download>{{$template->document_file}}<div class="float-right"><i class="fa fa-download"></i></div></a></td>
                            </tr>
                            @endforeach
                </tbody>
                    </table>                                                                 
        </div>              
    </div>      
</div>
<script>
        $(document).ready(function (){
       
            // Show All Data
  
            initdataTableDocumentAndTemplate();
            function initdataTableDocumentAndTemplate(){
                /*DataTable*/ 
                var table = $("#DocumentAndTemplate").DataTable({
                    "sDom": '<"customcontent">rt<"row"<"col-lg-6" i><"col-lg-6" p>><"clear">',
                    "paging": true,
                    "pageLength": 10,
                    "ordering": false,
                    scrollY: 500,
                    //  scrollX: true,
                    "autoWidth": true,
                    lengthChange: false,
                    responsive: true,
                    fixedColumns: true
                });
                /*Custom Search For DataTable*/
                $("#searchbox").on("keyup search input paste cut", function () {
                    table.search(this.value).draw();
                });
            }
        });

</script>      
@endsection
  