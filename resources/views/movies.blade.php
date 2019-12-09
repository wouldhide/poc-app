@extends('layout')

@section('title', 'Movies')

@section('content')
    <h1 class="mt-5 mb-5">Movie list</h1>

    <div class="card mb-5">
        <div class="card-header">Add your favorite movie</div>
        <div class="card-body">

            @if(session()->has('status'))
                <div class="alert alert-success mb-5" role="alert">{{ session()->get('status') }}</div>
            @endif

            <form action="{{ route('movies') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" type="text" class="form-control" id="title" placeholder="Title of your favorite movie">
                    @if($errors->has('title')) <p class="small text-danger">{{ $errors->first('title') }}</p>@endif
                </div>
                <div class="form-group">
                    <label for="release_year">Release year</label>
                    <input name="release_year" style="width: 200px" type="number" min="1900" max="3000" class="form-control" id="release_year" placeholder="Release year">
                    @if($errors->has('release_year')) <p class="small text-danger">{{ $errors->first('release_year') }}</p>@endif
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="2" placeholder="Short description ..."></textarea>
                    @if($errors->has('description')) <p class="small text-danger">{{ $errors->first('description') }}</p>@endif
                </div>
                <button type="submit" class="btn btn-primary">Add movie</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Favorite movies</div>
        <ul class="list-group list-group-flush">
        @foreach($movies as $movie)
            <li class="list-group-item">
                <strong>{{ $movie->title }} ({{ $movie->release_year }})</strong>
                <p>{{ $movie->description }}</p>
            </li>
        @endforeach
        </ul>
    </div>
@endsection
