@extends('layouts.master')

@section('content')
<div class="container">
<!-- Main content -->
<section class="content container">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua" style="background-color:#00C0EF"><i class="icon ion-md-cash" style="color:white;"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Uncollected Credits</span>
          <span class="info-box-number">0<small></small></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"  style="background-color:#00A65A;color:white"><i class="icon ion-md-cash"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total E-Wallet Balances</span>
          <span class="info-box-number">0</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon" style="background-color:#F39C12;color:white;"><i class="icon ion-md-people"></i></span>

        <div class="info-box-content">
   
          @if(auth()->user()->user_type_id===1)
          <a href="/manageuser/create" style="color:black;">
          <span class="info-box-text">Registered Employer</span> 
          <span class="info-box-number">{{$employers}}</span>
          </a>
          @elseif(auth()->user()->user_type_id===3)
          <a href="/enrollemployee" style="color:black;">
          <span class="info-box-text">Registered Employee</span> 
          <span class="info-box-number">{{$count_employee}}</span>
          </a>
          @elseif(auth()->user()->user_type_id===4) 
          <span class="info-box-text">Registered Employer</span> 
          <span class="info-box-number">{{$count_my_employeer}}</span>
          @else 
          <span class="info-box-number">0</span>
          @endif

        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon" style="background-color:#DD4B39;color:white;"><i class="icon ion-md-people"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Merchant Account</span>
          <span class="info-box-number">0</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
    
</section> 
  @if(auth()->user()->user_type_id === 4)
    <!-- Content List -->
  {{--  <div class="container-fluid border-secondary" style="background:white;border-radius:5px;padding:30px;"> 
          <div class="container" style="border-bottom:1px solid #3C8DBC;">
              <p class="brand-text font-weight-light" style="font-size:25px;"> Your Contents </p>   
          </div>
          <br>
                  @forelse($content as $contents) 
                      <div class="card" style="padding:30px;  box-shadow: 0px 3px #f2f2f2;">
                        <div class="card-header"> 
                            <i class="icon fa fa-calendar-o"> </i> 
                          {{$contents->content_title}} 

                            &#x6c;<span id="date_created_body"> {{ \Carbon\Carbon::parse($contents->created_at)->format('d/m/Y')}} </span>
                        </div>
                        <div class="card-body">
                          <blockquote class="blockquote mb-0">
                            <p>       {!! strip_tags(str_limit($contents->content_description,50)) !!}</p>  
                          </blockquote>  
                        </div>
                        <div class="text-center">
                          <p style="color:#3C8DBC;cursor: pointer;font-size:20px;" data-toggle="modal" data-title="{{$contents->content_title}}" data-description="<div id='imageview'>{{$contents->content_description}} </div>"  id="{{$contents->id}}" class="showfulldescription" data-target="#modal-lg"> See More   </p> 
                        </div>
                      </div>  
                      <br>
                      <div class="container" style="border-bottom:1px solid #3C8DBC;">
                        <p class="brand-text font-weight-light" style="font-size:25px;"> </p>   
                      </div>
                    
                    @empty
                    <div class="text-center">
                        <p style="color:#3C8DBC;font-size:20px;"> No content posted   </p> 
                    </div>   
                    <div class="container" style="border-bottom:1px solid #3C8DBC;">
                      <p class="brand-text font-weight-light" style="font-size:25px;"> </p>   
                    </div> 
                    @endforelse    
                    <div class="d-flex justify-content-center"> {{ $content->links() }} </div>     
                
        </div> 
    @else 
   --}} 
   <hr>
   <div class="row">
      <div class="col-sm-8">
       
                <div class="info-box">
                  <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
      
                  <div class="info-box-content ">
                    <span class="info-box-text">Employer Contents</span>
                    <span class="info-box-number">{{count($content)}}</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
        
            <ul class="timeline">
                <!-- timeline time label -->
                @forelse($content as $contents) 
                @php 
                  $get_read_status  = DB::table('employercontent as ec')
                  ->join('read_status as rs','ec.id','=','rs.employer_content_id')
                  ->where('ec.id','=',$contents->id)
                  ->where('rs.employee_id','=',auth()->user()->employee_id)
                  ->get();
                 @endphp 
                <li class="time-label" >
                      <span class="bg-red">
                          {{ \Carbon\Carbon::parse($contents->created_at)->isoFormat('LL')}}
                      </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-envelope bg-blue" style="color:#0093F0;background-color:white;"></i>
    
                  <div class="timeline-item">
                  <span class="time" id="{{$contents->id}}-action">
                    @if(count($get_read_status))
                    <span class='badge badge-primary'>Read</span>
                    @else 
                    <span class='badge badge-light'>Unread</span>
                    @endif 
                  </span>
    
                    <h3 class="timeline-header"><a href="#">Employer</a> sent you a message</h3>
    
                    <div class="timeline-body">
                        <div class="container-fluid">
                         
                      <h4> {{$contents->content_title}} </h4>
                      <div class="box-body img-thumbnail" id="content-{{$contents->id}}-body" style="display:none;overflow-wrap: break-word;">
                          {!! $contents->content_description !!}
                      </div>
                        </div>
                    </div>
                    <div class="timeline-footer">
                   {{-- <a class="btn btn-info btn-sm text-info showfulldescription btn-outline-info" data-toggle="modal" data-action="{{$contents->id}}" data-title="{{$contents->content_title}}" data-description="<div id='imageview'>{{$contents->content_description}} </div>"  id="{{$contents->id}}" class="showfulldescription" data-target="#modal-lg">Read Content</a>
                    --}}
                    <a class="btn btn-info btn-sm text-info btn-outline-info readmore" id-value="{{$contents->id}}"  data-action="{{$contents->id}}"><label id="{{$contents->id}}-label-value" label-value="show"> Read Content </label></a>
                    </div>
                  </div>
                </li> 

                @endforeach
                <div class="d-flex justify-content-center"> {{ $content->links() }} </div>  
       
            </ul>
                 @if(count($content)===0)
            
                <div class="justify-content-center info-box text-center mx-auto"> No available contents </div>
            
                 @endif
       
      </div>
      <div class="col-sm-4"> 
            <nav aria-label="breadcrumb" >
                <ol class="breadcrumb" style="background-color: white">
                  <li class="breadcrumb-item text-black" aria-current="page">Financial Tips</li>
                </ol>
              </nav>
              <div style="overflow: auto;height:700px;">
            <ul class="timeline">
         
            @foreach($financial as $financial_tips)
            <li>
                <i class="fa fa-comments bg-yellow" style="color:#F39C12;background-color:white;"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i>         {{ \Carbon\Carbon::parse($financial_tips->created_at)->isoFormat('LL')}}</span>

                  <h3 class="timeline-header"><a href="#">Employer</a> has a financial tips for you!</h3>

                  <div class="timeline-body">
                    {{$financial_tips->financial_tips_title}}
                  </div>
                  <div class="timeline-footer">
              {{--<a class="btn btn-warning btn-flat btn-outline-warning btn-sm financial-tips-btn"  data-title="{{$financial_tips->financial_tips_title}}" data-description="<div id='imageviewft'>{{$financial_tips->financial_tips_description}}</div>" data-toggle="modal" data-target="#modal-financial-tips">View Tips</a>    --}} 
                  <a href="#" class="btn btn-warning btn-flat btn-outline-warning btn-sm view-financial-tips"  data-title="{{$financial_tips->financial_tips_title}}" data-description="<div id='imageviewft'>{{$financial_tips->financial_tips_description}}</div>"> view </a>
                    
                </div>
                </div>
              </li>
            @endforeach
             
            </ul>
            @if(count($financial)===0)
            
            <div class="justify-content-center text-center mx-auto"> No available financial tips </div>
        
             @endif
          </div>

      </div>
    </div>

    @endif  
     
      
  </div>  

  @if(auth()->user()->user_type_id === 4)
{{--CAROUSEL --}} 
   {{-- <div class="container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            @foreach($content as $contents) 
            <li data-target="#carouselExampleIndicators" >
            </li>   
            @endforeach 
          </ol>
          <div class="carousel-inner">
            @foreach($content->take($count) as $contents)
            <div class="carousel-item @if($loop->first) active @endif ">
            <img class="d-block w-100" src="https://carepharmaceuticals.com.au/wp-content/uploads/sites/19/2018/02/placeholder-600x400.png" alt="{{$contents->content_title}}"> 
            <div class="carousel-caption d-none d-md-block">
                <h5>{{$contents->content_title}}</h5>
                <p>{{strip_tags($contents->content_description)}}</p> 
             
              </div>
            </div> 
            @endforeach
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
    </div>
  @else 
--}}
  @endif
{{--modal  for description --}} 
 <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
             
              <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                      <span id="create_date_modal"> </span><p class="modal-title" id="contenttitle">Content </p>
                  </li>  
                </ul>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body"> 
              <blockquote class="blockquote mb-0" id="contentdescription">
              </blockquote>
            </div>
       
            <div class="modal-footer justify-content-center"> 
            
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
  </div> 
  <div class="modal fade" id="modal-financial-tips">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
         
          <ul class="list-group list-group-flush">
              <li class="list-group-item">
                  <span id="create_date_modal"> </span><p class="modal-title" id="financial-tips-title">Content </p>
              </li>  
            </ul>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body"> 
          <blockquote class="blockquote mb-0" id="financial-tips-description">
          </blockquote>
        </div>
   
        <div class="modal-footer justify-content-center"> 
        
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> 



@endsection 
