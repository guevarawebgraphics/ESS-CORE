@extends('layouts.master')
@if (!Auth::check())
@section('content')
<div class="container">

    <div class="row justify-content-center text-center" style="margin-top: 20%;">
        <div class="col-md-6">
            <h2>Company Logo Here</h2>
        </div>
    </div> 
    
    <div class="row justify-content-center">       
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header text-center text-white">{{ __('Login') }}</div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <label for="username" class="col-md-3 offset-md-1 col-form-label text-md-right">{{ __('Username') }}</label>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="input-group">
                                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
                                    <div class="input-group-append">
                                        <span class="fa fa-user input-group-text"></span>
                                    </div>
                                </div>
                                
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <label for="password" class="col-md-3 offset-md-1 col-form-label text-md-right">{{ __('Password') }}</label>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="input-group">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                                    <div class="input-group-append">
                                        <span class="fa fa-lock input-group-text"></span>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
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
                        <br>
                        {{-- <div class="form-group row">
                            <div class="col-md-6 offset-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>                               
                            </div>                                                    
                        </div> --}}

                        <div class="form-group row">
                            {{-- <div class="col-md-7 offset-md-1">                               
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif                               
                            </div> --}}

                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">
                                        <i class="fa fa-sign-in-alt"></i>
                                    {{ __('Login') }}
                                </button>                                
                            </div>              
                        </div>
                                            
                    </form>
                </div>
            </div>
        </div>
    </div>
      
</div>
@endsection
@endif