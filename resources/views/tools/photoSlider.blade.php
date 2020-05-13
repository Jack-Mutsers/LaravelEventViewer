@if(!empty($images) > 0)

<link href="{{ asset('css/photoSlider.css') }}" rel="stylesheet">

<!-- 1. Add latest jQuery and fancybox files -->

<script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<!-- 2. Create links -->

<div class="col-md-12">
    <div class="masonry-wrapper">
        <div class="masonry">
            @foreach($images as $image)
                <div class="masonry-item">
                    <?php $value = is_object($image) ? asset($image->url): $image; ?>

                    <a data-fancybox="gallery" href="{{ $value }}"><img class="masonry-content" src="{{ $value }}"></a>
                </div>
            @endforeach
        </div>
    </div>
</div>

@else

<div class="col-md-12">
    No photos have been uploaded yet.
</div>

@endif