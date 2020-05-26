@extends('layouts.app')

@section('content')
<link href="{{ asset('css/events.css') }}" rel="stylesheet">
<script src="{{ asset('js/events.js') }}"></script>
<script>
    var imageDirectory = '{{asset("images")}}';
</script>

<div class="row">
    <div class="col-md-12">

        <div class="filterField"> <!-- sortings -->
            <div class="select_container">
                <select class="form-control select" id="sort_item">
                    <option value="startdate">startdate</option>
                    <option value="name">name</option>
                </select>
            </div>

            <div class="select_container">
                <select class="form-control select" id="sort_dir">
                    <option value="1">Ascending</option>
                    <option value="0">Descending</option>
                </select>
            </div>

            <div class="button_container">
                <button class="form-control" type="button" id="sort">Sort</button>
            </div>
        </div>

        <div class="filterField"> <!-- genre filters -->
            <div class="select_container">
                <select class="form-control select" id="filter_item">
                    <option value="0">None</option>
                    @foreach($genres as $key => $genre)
                        <option value="{{$genre->id}}">{{$genre->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="button_container">
                <button type="button" class="form-control" id="filter">Filter</button>
            </div>
        </div>

        <div class="filterField"> <!-- sortings -->
            <div class="row">
                <div class="select_container">
                    <input type="text" class="form-control" id="SearchBar">
                </div>
                <div class="button_container">
                    <button type="button" class="form-control" id="search">Search</button>
                </div>
            </div>
        </div>

    </div>
</div>
<hr>
<div class="content-container">
    <div class="row" id="event_container">
        @foreach($events as $key => $val)
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <a href="Event/{{ $val->id }}" class="card">
                    <div class="card-header">
                        <?php $value = isset($val->poster) && !empty($val->poster) ? json_decode($val->poster)->url : ""; ?>
                        <img src="{{ asset($value) }}" alt="">
                    </div>
                    <div class="card-footer">
                        <h3>{{$val->name}}</h3>
                        <p>
                            @foreach($val->genre as $eventGenre)    
                                <div class="genre-tag">{{$eventGenre->genre->name}}</div>
                            @endforeach
                        </p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
