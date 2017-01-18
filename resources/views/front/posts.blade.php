@extends('welcome')

@section('content')
    <div class="title m-b-md">
        Blog
    </div>

    <div class="row text-center">
        @foreach($posts as $post)
            <div class="col-lg-3 text-center post">
                <h4>{{ $post->name }}</h4>
                <br>
                <a href="/blog/{{ $post->slug }}">
                    <img class="img-rounded" src="{{ $post->preview }}" alt="{{ $post->name }}">
                </a>
                <hr>
                <p>{{ $post->preview_text }}</p>
                <small>{{ $post->created_at }}</small>
            </div>
        @endforeach
    </div>
@endsection