@extends('layout')

@section('title', 'IMDB Search')

@section('content')
    <h1 class="mt-5 mb-5">Search IMDB movies</h1>

    <div class="card mb-5">
        <div class="card-header">Search for a movie</div>
        <div class="card-body">

            <form method="get">
                @csrf
                <div class="form-group">
                    <label for="search">Movie title</label>
                <input name="search" type="text" class="form-control" id="search" placeholder="Search for a movie by title" value="{{ $search }}">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <div class="card mb-5">
        @if($result)
        <div class="card-header">Search results for <strong>{{ $search }}</strong></div>
        <div class="card-body">
            <p class="mb-10">Number of results: <strong>{{ $result->totalResults }}</strong></p>
            
            @foreach($result->Search as $movie)
                <div class="media mb-3">
                    <img style="width:150px;" src="{{ $movie->Poster }}" class="mr-3" alt="{{ $movie->Title }}">
                    <div class="media-body">
                        <h5 class="mt-0">{{ $movie->Title }} ({{ $movie->Year }})</h5>
                        <a href="{{ route('imdb.show', ['imdb_id' => $movie->imdbID]) }}">View details</a>
                    </div>
                    </div>
            @endforeach

        </div>
        @else
            <div class="card-body">
                <p>Please enter a title to search</p>
            </div>
        @endif
    </div>
@endsection
