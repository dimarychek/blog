@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(Session::has('message'))
                <div class="alert alert-success">{{ Session::get('message') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading"><a href="/home">Dashboard</a></div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/home/create" class="btn btn-primary">Add post</a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class=col-lg-12>
                            <table class="table table-bordered table-hover table-striped">
                                <tr class="info">
                                    <td><b>ID</b></td>
                                    <td><b>Preview</b></td>
                                    <td><b>Name</b></td>
                                    <td><b>Action</b></td>
                                    <td><b>Action</b></td>
                                </tr>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>@if(isset($post->preview)) <img style="width: 34px;" class="img-responsive img-rounded" src="{{ $post->preview }}">@endif</td>
                                        <td>{{ $post->name }}</td>
                                        <td><a href="{{ action('HomeController@edit', ['back' => $post->id]) }}" class="btn btn-primary">Edit</a></td>
                                        <td>
                                            <form method="POST" action="{{ action('HomeController@destroy', ['back' => $post->id]) }}">
                                                <input type="hidden" name="_method" value="delete"/>
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                <input type="submit" class="btn btn-danger delete_confirm" value="Delete"/>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
