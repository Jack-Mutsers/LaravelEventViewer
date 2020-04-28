@extends('layouts.app')

@section('content')
<link href="{{ asset('css/event.css') }}" rel="stylesheet">
<div class="content-container">

    <div class="row">
        <div class="col-md-12">
            <!-- event title -->
            <h2>{{$event->name}}</h2>
        </div>
    </div>

    <div class="row" id="content-header">
        <div class="col-md-4" id="poster-container">
            <!-- poster -->
            @if($event->next != null)
                <img src="{{$event->next->event_date->poster}}" alt="">
            @else
                <img src="{{$event->poster}}" alt="">
            @endif
        </div>
        
        <div class="col-md-1 col-sm-hidden"></div>
        
        <div class="col-md-7">
            <div class="row" id="event-data">
                <!-- info about event -->
                <p>{{$event->description}}</p>
            </div>
            <div class="row" id="event-info">
                <div class="col-md-4 box" id="box-left">
                    <!-- date upcomming event -->
                    <span class="boldTitle">Event Date:</span> <br/>
                    @if($event->next != null)
                        <span class="box-item">{{$event->next->start}}</span>
                    @else
                        <span class="box-item">There is no event planned yet</span>
                    @endif
                </div>
                <div class="col-md-7 box" id="box-right">
                    <!-- location of next event -->
                    <span class="boldTitle">Location:</span> <br/>
                    @if($event->next != null && !empty($event->next->event_date->location))
                        <span class="box-item">{{$event->next->event_date->location}}</span>
                    @else
                        <span class="box-item">There is no location known at this moment</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="content-details">
        <div class="col-md-6">
            <div id="genre-container">
                <!-- event genres -->
                <span class="boldTitle">Genres:</span>
                <ul>
                    @foreach($event->genre as $genre)
                        <li>{{$genre->name}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div id="artist-container">
                <!-- artists that will come in the next event -->
                <span class="boldTitle">Artists:</span>
                <div class="row">
                    @if($event->next != null)
                        @foreach($event->next->event_date->artists as $artist)
                            <div class="col-md-4">
                                <li>{{$artist->name}}</li>
                            </div>
                        @endforeach
                    @else
                        <span>There are no artists availible at this moment</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="content-sales">
        <!-- link naar bestel site -->
    </div>

    @if(count($event->finished) > 0)
        <div class="row">
            <div class="col-md-12">
                <h2>Past Events</h2>
            </div>
        </div>

        <div class="row">
            <!-- past events -->
            @foreach($event->finished as $oldEvent)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <a href="EventDate/{{ $oldEvent->id }}" class="card">
                        <div class="card-header">
                            <img src="{{ $oldEvent->event_date->poster }}" alt="">
                        </div>
                        <div class="card-footer">
                            <p>{{$oldEvent->start}}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <div id="content-footer"></div>
</div>
@endsection
