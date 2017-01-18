@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><a href="/home">Dashboard</a></div>

                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">Check out all the required fields.</div>
                        @endif
                        @if(Session::has('message'))
                            <div class="alert alert-success">{{ Session::get('message') }}</div>
                        @endif
                        <form method="POST" action="{{ action('HomeController@store') }}" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>URL *</label>
                                        <input type="text" name="slug" class="form-control" placeholder="URL" value="{{ old('slug') }}" required>
                                        <p class="help-block">Page address must be unique and latin lowercase.</p>
                                    </div>
                                    <div class="form-group text-primary">
                                        <label>Name *</label>
                                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="form-group text-primary">
                                        <label>Preview text</label>
                                        <textarea name="preview_text" id="editor" class="form-control" rows="5" placeholder="Preview text">{{ old('preview_text') }}</textarea>
                                    </div>
                                    <div class="form-group text-primary">
                                        <label>Content</label>
                                        <textarea name="content" id="editor" class="form-control" rows="10" placeholder="Content">{{ old('content') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Превью</label>
                                        <input type="file" name="preview" value="{{ old('preview') }}">
                                    </div>
                                    <hr>
                                    <p class="help-block">* required fields.</p>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection