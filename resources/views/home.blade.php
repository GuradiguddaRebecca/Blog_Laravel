@extends('layouts.app')
<style type="text/css">
    .avatar{
        border-radius: 100%;
        max-width: 100px;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($errors)>0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif 
        
        <div class="card-body">
            @if (session('response'))
                <div class="alert alert-success" role="alert">
                    {{ session('response') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col-md-4">
                    @if(!empty($profile))
                    <img class="avatar" src="{{ @$profile->profile_pic }}" alt="">
                    @else
                    <img class="avatar" src="{{ url('images/profile-pic.jpg') }}" alt="">
                    @endif

                    @if(!empty($profile))
                    <p class="lead">{{ @$profile->name }}</p>
                    @else
                    <p></p>
                    @endif

                    @if(!empty($profile))
                    <p class="lead"> {{ @$profile->designation }} </p> 
                    @else
                    <p></p>
                    @endif
                    
                    
            
                    </div>
                    <div class="col-md-8"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
