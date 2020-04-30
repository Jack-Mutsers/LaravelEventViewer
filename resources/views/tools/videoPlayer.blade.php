@if(!empty($videos) > 0)

<link href="{{ asset('css/videoPlayer.css') }}" rel="stylesheet">

<!-- 1. Add latest jQuery and fancybox files -->

<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<!-- 2. Create links -->

@foreach($videos as $video)
    <?php 
        $video_id = explode("=", $video)[1];
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 video-box">
        <a data-fancybox="gallery" href="{{$video}}"><img class="" src="http://img.youtube.com/vi/{{$video_id}}/hqdefault.jpg"></a>
    </div>
@endforeach

@else

<div class="col-md-12">
    No videos have been uploaded yet.
</div>

@endif