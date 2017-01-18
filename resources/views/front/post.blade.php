@extends('welcome')

@section('content')
    @foreach($post as $item)
        <div class="title m-b-md">
            {{ $item->name }}
        </div>
        <img class="img-rounded" src="{{ $item->preview }}" alt="{{ $item->name }}">
        <div class="text-center">
            <br>
            <p>{{ $item->content }}</p>
            <small>{{ $item->created_at }}</small>
            <hr>
            <a href="/" class="text-center">Watch all</a>
        </div>
    @endforeach
@endsection