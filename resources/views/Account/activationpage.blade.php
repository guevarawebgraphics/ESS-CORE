@extends('layouts.master')
@if (!Auth::check())
@section('content')
    <div class="container">

        <div class="row justify-content-center" style="margin-top: 20%;">
            <div class="col-md-6">
                <div class="card card-outline card-primary shadow p-3 mb-5 bg-white rounded">
                    <div class="card-header text-center text-black"><label>Account Activation</label></div>

                    <div class="card-body">
                        <!-- Start Form-->
                        <form method="POST" action="{{ url('/Account/ActivateUser') }}">
                            @csrf
                            <!--Username Field-->
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="input-group">
                                        {{-- <div class="input-group-append">
                                            <span class="fa fa-user input-group-text" style="background-color: #fff;"></span>
                                        </div> --}}
                                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="Username" >
                                    </div>
                                    
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--End Username Div -->
                            <!--Activation Code -->
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="input-group">
                                        {{-- <div class="input-group-append">
                                            <span class="fa fa-lock input-group-text" style="background-color: #fff;"></span>
                                        </div> --}}
                                        <input id="activation_code" type="activation_code" class="form-control{{ $errors->has('activation_code') ? ' is-invalid' : '' }}" name="activation_code" placeholder="Activation Code" >
                                    </div>
                                    @if ($errors->has('activation_code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('activation_code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!--End Activation Code /Div-->
                            <!--Errors-->
                            <br>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <span><i class="fa fa-check-circle"></i></span>
                                    {{session('success')}}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    <span><i class="fa fa-exclamation-circle"></i></span>
                                    {{session('error')}}
                                </div>
                            @endif
                            <!--End Errors-->
                            <!--Button Row-->
                            <div class="form-group row">
                                <div class="col-md-8 offset-md-2">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                                        Activate Account
                                        {{-- <ion-icon name="log-in"></ion-icon> --}}
                                        <i class="icon ion-md-log-in"></i>
                                    </button>                                
                                </div>              
                            </div>
                            <!--End Button Row-->
                        </form>
                        <!--End Form-->
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@endif