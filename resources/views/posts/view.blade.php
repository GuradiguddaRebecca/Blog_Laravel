@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('response'))
            <div class="alert alert-success" role="alert">
                {{ session('response') }}
            </div>
            @endif
        
        <div class="card-body">
           
            <div class="card">
                <div class="card-header">{{ __('Post View') }}</div>

                <div class="card-body">
                    <div class="col-md-4">
                        <ul class="list-group">
                            @if(count($categories)>0)
                                @foreach($categories as $category)
                        <li class="list-group-item"><a href='{{url("category/{$category->id}")}}'>
                            {{$category->category}}</a></li> 
                                @endforeach
                            @else
                                <p>No Category Found</p>
                            @endif
                            
                        </ul>
                    
            
                    </div>
                    <div class="col-md-8">
                        @if(count($posts)>0)
                            @foreach($posts as $post)
                                <h4>{{ $post->post_title }}</h4>
                                <img src="{{ $post->post_image }}" alt="">
                                <p>{{ $post->post_body }}</p>

                                <ul class="nav nav-pills">
                                    <li role="presentation">
                                    <a href='{{ url("/like/{$post->id}") }}'>
                                            <span class="fa fa-thumbs-up"> Like ({{$likeCtr}}) </span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href='{{ url("/dislike/{$post->id}") }}'>
                                            <span class="fa fa-thumbs-down"> Dislike ({{$dislikeCtr}}) </span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href='{{ url("/comment/{$post->id}") }}'>
                                            <span class="fa fa-comment-o"> COMMENT </span>
                                        </a>
                                    </li>
                                </ul>

                                
                            @endforeach
                    
                        @else
                            <p>No post available</p>
                        @endif
                        
                        <form method="POST" action='{{ url("/comment/{$post->id}" ) }}'>
                            @csrf
    
                            <div class="form-group row">
                                <textarea id="comment" rows="7" type="comment" class="form-control @error('comment') is-invalid @enderror" name="comment"  required autocomplete="comment"></textarea>
                            </div>
                            
                            <div class="form-group row">
                                <button type="submit" class="btn btn-primary btn-large btn-block">
                                    {{ __('Post Comment') }}
                                </button>
                            </div>
                        </form>  
                        
                        <h3>Comment</h3>
                        @if(count($comments)>0)
                            @foreach($comments as $comment)
                                <p>{{ $comment->comment }}</p>
                                <p>Posted by:{{ $comment->name }}</p>
                                <hr>
                            @endforeach
                    
                        @else
                            <p>No comments available</p>
                        @endif
                            </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
