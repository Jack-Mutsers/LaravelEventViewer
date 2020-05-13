@extends('layouts.app')

@section('content')
<link href="{{ asset('css/event.css') }}" rel="stylesheet">
<div class="content-container">

    <div class="row" id="content-title">
        <div class="col-md-12">
            <!-- event title -->
            <h2>{{$event->name}}</h2>
        </div>
    </div>

    <div class="row" id="content-header">
        <div class="col-md-4" id="poster-container">
            <!-- poster -->
            @if($event->next != null)
                <?php $poster = json_decode($event->next->event_date->poster) ?>
                <?php $value = is_object($poster) ? asset($poster->url) : $poster; ?>
                <img src="{{ $value }}" alt="">
            @else
                <?php $poster = json_decode($event->poster) ?>
                <?php $value = is_object($poster) ? asset($poster->url): $poster; ?>
                <img src="{{ $value }}" alt="">
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
                        <span class="box-item">{{$event->next->start->format('d F Y')}}</span>
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
                    @foreach($event->genre as $eventGenre)
                        <li>{{$eventGenre->genre->name}}</li>
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


    @if($event->next != null && count($event->next->event_date->stages) > 0)
        <div class="row">
            <div class="col-md-12">
                <h2>planning</h2>
            </div>
        </div>

        <div class="row" id="content-schedule">
            <!-- foldable stages + schedule -->
            <ul class="nav nav-pills">
                <?php $stageCount = 0; ?>
                @foreach($event->next->event_date->stages as $stage)
                    <?php $stageCount++; ?>
                    <li><a class="{{$stageCount == 1? 'active':''}} nav_link" data-toggle="tab" href="#stage{{$stageCount}}"><span class="boldTitle">{{$stage->name}}</span></a></li>
                @endforeach
            </ul>

            <div class="col-md-12 box tab-content">
                <?php $stageCount = 0; ?>
                @foreach($event->next->event_date->stages as $stage)
                    <?php $stageCount++; ?>
                    <div id="stage{{$stageCount}}" class="tab-pane fade {{$stageCount == 1? 'in active show':''}}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Start</th>
                                    <th>Duration</th>
                                    <th>Artist</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stage->schedule[0]->scheduleItems as $schedule_item)
                                    <tr>
                                        <td>{{$schedule_item->start->format("H:i:s")}}</td>
                                        <td>{{$schedule_item->stage_time}}</td>
                                        <td>{{$schedule_item->artist->name}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    @endif


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
                            <?php $poster = json_decode($oldEvent->event_date->poster) ?>
                            <?php $value = is_object($poster) ? asset($poster->url): $poster; ?>
                            <img src="{{ $value }}" alt="">
                        </div>
                        <div class="card-footer">
                            <p>{{$oldEvent->start->format('F Y')}}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <div id="content-footer"></div>
</div>
@endsection
