@extends('layouts.app')

@section('content')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">

<div class="content-container">
@if(!empty($DatePlanning))

    <div class="row">
        <h2> Upcomming event </h2>
    </div>

    <div class="row">
        <div class="col-md-5" id="content-header">
            <div id="poster-container">
                <?php $value = isset($DatePlanning->event_date->poster) && !empty($DatePlanning->event_date->poster) ? json_decode($DatePlanning->event_date->poster)->url : ""; ?>
                <a href="/Event/{{$DatePlanning->eventid}}"><img src="{{ asset($value) }}" alt=""></a>
            </div>    
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <a class="header-link" href="/Event/{{$DatePlanning->eventid}}"><h3>{{$DatePlanning->event->name . " - " . $DatePlanning->start->format("F Y")}}</h3></a>
                </div>

                <div class="col-md-12">
                    <label for="spnstartDate">Start Date: </label>
                    <span name="spnstartDate" id=spnstartDate>{{$DatePlanning->start->format("d F Y")}}</span>
                </div>

                <div class="col-md-12">
                    <label for="spnEndDate">End Date: </label>
                    <span name="spnEndDate" id=spnEndDate>{{$DatePlanning->end->format("d F Y")}}</span>
                </div>

                <div class="col-md-12">
                    <label for="spnLocation">Location: </label>
                    <span name="spnLocation" id=spnLocation>{{$DatePlanning->event_date->location}}</span>
                </div>

                <div class="col-md-12">
                    <p>{{$DatePlanning->event->description}}</p>
                </div>

                @if(!empty($DatePlanning->event_date->order_link))
                    <div class="col-md-12">
                        <a href="{{$DatePlanning->event_date->order_link}}">Order your tickets here</a>
                    </div>
                @endif

            </div>
        </div>
    </div>

    @include('tools.interactiveCalander')
@else

    <h1>No dates have been found</h1>

@endif
</div>
@endsection
