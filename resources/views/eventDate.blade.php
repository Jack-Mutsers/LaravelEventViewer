@extends('layouts.app')

@section('content')
<link href="{{ asset('css/eventdate.css') }}" rel="stylesheet">
<div class="content-container">
    <div class="row" id="content-title">
        <div class="col-md-12">
            <h2>{{$eventdate->event->name}} - {{$eventdate->datePlanning->start->format('F Y')}}</h2>
        </div>
    </div>
    
    <div class="row" id="content-header">
        <div class="col-md-5" id="poster-container">
            <!-- poster -->
            <img src="{{$eventdate->poster}}" alt="">
        </div>
        
        <div class="col-md-1 col-sm-hidden"></div>
        
        <div class="col-md-6">
            <div class="row event-info">
                <div class="col-md-12 box">
                    <!-- location of next event -->
                    <span class="boldTitle">Location:</span> <br/>
                    @if(!empty($eventdate->location))
                        <span class="box-item">{{$eventdate->location}}</span>
                    @else
                        <span class="box-item">There is no location known at this moment</span>
                    @endif
                </div>
            </div>

            <div class="row event-info">
                <div class="col-md-12 box">
                    <!-- date upcomming event -->
                    <span class="boldTitle">Event Date:</span> <br/>
                    <span class="box-item">{{$eventdate->datePlanning->start->format('d F Y')}}</span>
                </div>
            </div>

            <div class="row event-info">
                <!-- list of artists that performed on the event -->
                @foreach($eventdate->artists as $artist)
                    <div class="col-md-4">
                        <li>{{$artist->name}}</li>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3>Photos</h3>    
        </div>
    </div>

    <div class="row" id="content-fotos">
        <?php $images = json_decode($eventdate->images); ?>

        @include('tools.photoSlider')
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3>Videos</h3>    
        </div>
    </div>

    <div class="row" id="content-videos">
        <?php $videos = json_decode($eventdate->videos); ?>

        @include('tools.videoPlayer')
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3>Reviews</h3>    
        </div>
    </div>
    
    <div class="row" id="content-reviews">
        <hr class="col-md-12" />
        @foreach($eventdate->reviews as $review)
            <div class="col-md-12 review">
                <div class="row review-header">
                    <div class="col-md-12">
                        <span class="boldTitle">{{$review->user->name}}:</span> 
                        
                        @for( $x = 0; $x < $review->rating; $x += 2 )
                        
                            @if( floor( $review->rating )-$x >= 2 )
                                <i class="fas fa-star rating-star"></i>
                            @elseif( $review->rating-$x > 0 )
                                <i class="fas fa-star-half-alt rating-star"></i>
                            @else
                                <i class="far fa-star rating-star"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <div class="row review-body">
                    <div class="col-md-12">
                        <p>{{$review->review}}</p>
                    </div>
                </div>
            </div>
            <hr class="col-md-12" />
        @endforeach
    </div>
</div>
@endsection
