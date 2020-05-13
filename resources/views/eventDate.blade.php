@extends('layouts.app')

@section('content')
<link href="{{ asset('css/eventdate.css') }}" rel="stylesheet">
<script src="{{ asset('js/eventdate.js') }}"></script>

<div class="content-container">
    <div class="row" id="content-title">
        <div class="col-md-12">
            <h2>{{$datePlanning->event->name}} - {{$datePlanning->start->format('F Y')}}</h2>
        </div>
    </div>
    
    <div class="row" id="content-header">
        <div class="col-md-5" id="poster-container">
            <!-- poster -->
            <?php $value = isset($datePlanning->event_date->poster) && !empty($datePlanning->event_date->poster) ? json_decode($datePlanning->event_date->poster)->url : ""; ?>
            <img src="{{ asset($value) }}" alt="">
        </div>
        
        <div class="col-md-1 col-sm-hidden"></div>
        
        <div class="col-md-6">
            <div class="row event-info">
                <div class="col-md-12 box">
                    <!-- location of next event -->
                    <span class="boldTitle">Location:</span> <br/>
                    @if(!empty($datePlanning->event_date->location))
                        <span class="box-item">{{$datePlanning->event_date->location}}</span>
                    @else
                        <span class="box-item">There is no location known at this moment</span>
                    @endif
                </div>
            </div>

            <div class="row event-info">
                <div class="col-md-12 box">
                    <!-- date upcomming event -->
                    <span class="boldTitle">Event Date:</span> <br/>
                    <span class="box-item">{{$datePlanning->start->format('d F Y')}}</span>
                </div>
            </div>

            <div class="row event-info">
                <!-- list of artists that performed on the event -->
                @if(!empty($datePlanning->event_date->artists))
                    @foreach($datePlanning->event_date->artists as $artist)
                        <div class="col-md-4">
                            <li>{{$artist->name}}</li>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3>Photos</h3>    
        </div>
    </div>

    <div class="row" id="content-photos">
        <?php $images = json_decode($datePlanning->event_date->images); ?>

        @include('tools.photoSlider')
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3>Videos</h3>    
        </div>
    </div>

    <div class="row" id="content-videos">
        <?php $videos = json_decode($datePlanning->event_date->videos); ?>

        @include('tools.videoPlayer')
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3>Reviews</h3>    
        </div>
    </div>
    
    @if(session("user") != null)
    <div class="row" id="content-form">
        <div class="col-md-12">
            <!-- rating -->
            <div class="starRating" data-number="1" id="starRating1"><i class="far fa-star rating-star"></i></div>
            <div class="starRating" data-number="2" id="starRating2"><i class="far fa-star rating-star"></i></div>
            <div class="starRating" data-number="3" id="starRating3"><i class="far fa-star rating-star"></i></div>
            <div class="starRating" data-number="4" id="starRating4"><i class="far fa-star rating-star"></i></div>
            <div class="starRating" data-number="5" id="starRating5"><i class="far fa-star rating-star"></i></div>
            
            <br />
            
            <form id="review-form" action="AddReview" method="post">
                @CSRF
                <input type="hidden" name="event_date_id" value="{{$datePlanning->event_date->id}}">
                <input type="hidden" id="starRating" name="rating" value="0">
                <textarea placeholder="Write your review here..." name="review" class="form-control" id="review" cols="30" rows="10"></textarea>
                <br>            
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
                
        </div>
    </div>
    @endif


    <hr/>

    <div class="row" id="content-reviews">
        @if(!empty($datePlanning->event_date->reviews))
            @foreach($datePlanning->event_date->reviews as $review)
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
            
        @else

            <div class="col-md-12">
                There are no Reviews submitted yet.
            </div>

        @endif
    </div>
</div>
@endsection
