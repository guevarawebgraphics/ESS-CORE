<!-- Styles -->
<style>
    #error {          
        color: #636b6f;       
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }
    
    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>

@extends('layouts.master')

@section('content')
    <div class="content">
        <div id="error" class="title m-b-md">
            No Access
        </div>          
    </div>
@endsection
