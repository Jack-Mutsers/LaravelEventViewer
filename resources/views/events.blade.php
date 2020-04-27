@extends('layouts.app')

@section('content')
<link href="{{ asset('css/events.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        @foreach($events as $key => $val)
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <a href="Event/{{ $val->id }}" class="card">
                    <div class="card-header">
                        <img src="{{ $val->poster }}" alt="">
                    </div>
                    <div class="card-footer">
                        <h3>{{$val->name}}</h3>
                        <p>
                            @foreach($val->genre as $genre)    
                                <div class="genre-tag">{{$genre}}</div>
                            @endforeach
                        </p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
