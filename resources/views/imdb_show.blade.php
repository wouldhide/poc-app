@extends('layout')

@section('title', 'IMDB movie details')

@section('content')

    <p><button class="btn btn-link mt-3" onclick="window.history.back()"><< Back to search results</button></p>

    <div class="card mb-5">
        <div class="card-body">
            
            <h3>{{ $movie['Title'] }} ({{ $movie['Year'] }})</h3>
            <img class="mb-5" src="{{ $movie['Poster'] }}" alt="{{ $movie['Title'] }}">

            <dl class="row">
                @foreach(array_keys($movie) as $item)
                    @if(!\in_array($item, ['Title', 'Year', 'Poster']) and ! is_array($movie[$item]))
                        <dt class="col-sm-3">{{ $item }}</dt>
                        <dd class="col-sm-9">{{ $movie[$item] }}</dd>
                    @endif
                @endforeach

            </dl>

        </div>
    </div>

@endsection
