@extends('layouts.master')

@section('content')
<div class="container">
<!-- Main content -->
<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color:#00C0EF">
            <div class="inner">
              <h3>0</h3>

              <p>Uncollected Credits</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-bag"></i> --}}
              <i class="icon ion-md-cash"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color:#00A65A">
            <div class="inner">
              <h3>0</h3>

              <p>Total E-Wallet Balances</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-cash"></i> --}}
              <i class="icon ion-md-cash"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color:#F39C12">
            <div class="inner">
              @if(auth()->user()->user_type_id === 1)    {{-- Admin --}}
              <h3>{{ $employers}}</h3>
              <p>Registered Employer</p>
              @elseif(auth()->user()->user_type_id===3)  {{-- Employer --}}
              <h3>{{$count_employee}}</h3>               {{--  Variable for counting employee --}}
              <p>Registered Employee</p> 
              @elseif(auth()->user()->user_type_id===4) 
              <h3>{{$count_my_employeer}}</h3>             
              <p>Registered Employer</p> 
              @endif 
      
            </div>
            <div class="icon">
              {{-- <i class="ion ion-person-add"></i> --}}
              <i class="icon ion-md-person"></i>
            </div>
            @if(auth()->user()->user_type_id ===3)  {{-- Employer --}}
            <a href="{{route('enrollemployee')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> 
            @else 
            <a href="/Account" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>    {{-- Employee --}}
            @endif
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color:#DD4B39">
            <div class="inner">
              <h3>0</h3>

              <p>Merchant Account</p>
            </div>
            <div class="icon">
              {{-- <i class="ion ion-person-stalker"></i> --}}
              <i class="icon ion-md-people"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      </section> 
  @if(auth()->user()->user_type_id === 4)
    <!-- Content List -->
      <div class="container-fluid border-secondary" style="background:white;border-radius:5px;padding:30px;"> 
          <div class="container" style="border-bottom:1px solid #3C8DBC;">
              <p class="brand-text font-weight-light" style="font-size:25px;"> Your Contents </p>   
          </div>
          <br>
                  @forelse($content as $contents) 
                      <div class="card" style="padding:30px;  box-shadow: 0px 3px #f2f2f2;">
                        <div class="card-header"> 
                            <i class="icon fa fa-calendar-o"> </i> 
                          {{$contents->content_title}}
                            {{--<button type="button" class="close" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>  
                            --}}
                            &#x6c;<span id="date_created_body"> {{ \Carbon\Carbon::parse($contents->created_at)->format('d/m/Y')}} </span>
                        </div>
                        <div class="card-body">
                          <blockquote class="blockquote mb-0">
                            <p>       {!! strip_tags(str_limit($contents->content_description,50)) !!}</p>  
                          </blockquote>  
                        </div>
                        <div class="text-center">
                          <p style="color:#3C8DBC;cursor: pointer;font-size:20px;" data-toggle="modal" data-title="{{$contents->content_title}}" data-description="{{$contents->content_description}}"  id="{{$contents->id}}" class="showfulldescription" data-target="#modal-lg"> See More   </p> 
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
        </div> 
    @else 


    @endif 
  </div>  
  @if(auth()->user()->user_type_id === 4)
{{--CAROUSEL --}} 
    <div class="container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            @foreach($content as $contents) 
          {{--  <li data-target="#carouselExampleIndicators" data-slide-to="{{$contents->id}}" @if($loop->first) class="active" @endif>
            </li> 
            
            --}}
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

@endsection 
