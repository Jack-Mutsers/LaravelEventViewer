@extends('layouts.adminapp')

@section('content')
@if (Session::has('success'))
    {{ Session::get('success') }}
@endif

<link href="{{ asset('css/admin/event.css') }}" rel="stylesheet">
<script src="{{ asset('js/admin/event.js') }}"></script>
<?php 
    $input = isset($event) ? $event : null;
    $input = Session::has('input') ? Session::get('input') : $input;
?>
    <div class="container">
        @include('tools.flash-message')
        <h1>{{$name}}</h1>
        
        <hr>

        <div class="row">
            <div class="col-md-12">
                <button onclick="history.go(-1);" class="btn btn-primary" type="button">Back</button>
            </div>
        </div>

        <hr>

        <form action="/admin/event/SaveEvent" id="SaveEvent" method="post" enctype="multipart/form-data">
            @CSRF

            @if(isset($event->id) && !empty($event->id))
                <input type="hidden" name="id" value="{{ $event->id }}">
            @endif

            <!-- Nav pills -->
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#general_tab">General</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#poster_tab">Poster</a>
                </li>
            </ul>

            <hr>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="general_tab" class="container tab-pane active"><br>

                    <div class="row form-group">
                        <div class="col-md-2"><label for="username">Active:</label></div>
                        <div class="col-md-10">
                            <?php $value = isset($input->active) ? $input->active : true; ?>
                            <input type="checkbox" class="" name="active" id="active" <?php echo $value ? "checked" : ""; ?>>
                        </div>
                    </div>
                
                    <div class="row form-group">
                        <div class="col-md-2"><label for="username">Name:</label></div>
                        <div class="col-md-10">
                            <?php $value = isset($input->name) ? $input->name : ""; ?>
                            <input type="text" class="form-control" name="name" id="name" value="{{$value}}">
                        </div>
                    </div>
                
                    <div class="row form-group">
                        <div class="col-md-2"><label for="username">Description:</label></div>
                        <div class="col-md-10">
                            <?php $value = isset($input->description) ? $input->description : ""; ?>
                            <textarea name="description" class="form-control" id="description">{{$value}}</textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-2"><label>Preference:</label></div>
                        <div class="col-md-10">
                            <?php $json = isset($input->genre) && is_array($input->genre) ? json_encode($input->genre) : ""; ?>
                            <input class="form-control" type="hidden" name="genre" id="genre" value="{{$json}}">
                            <div id="genre-container">
                                <?php $values = isset($input->genre) && is_array($input->genre) ? $input->genre : array(); ?>
                                @foreach($genres as $genre)
                                    <div class="genreSelector <?php echo in_array($genre->id, array_column($values, 'genre_id'))? 'selected' : ""; ?>" data-genre="{{$genre->id}}">{{$genre->name}}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
                <div id="poster_tab" class="container tab-pane fade"><br>

                    <div class="uploader_field">
                        <?php $value = isset($input->poster) && !empty($input->poster) ? json_decode($input->poster)->name : ""; ?>
                        <div class="row upload_button_field" >
                            <div class="col-md-12">
                                <input class="hidden" type="file" id="posterImage" name="posterImage" onchange="readURL(this);" /> 
                                <input class="hidden" type="text" id="posterOldName" name="posterOldName" value="{{ $value }}" /> 
                                <input class="hidden" type="text" id="posterCurrentName" name="posterCurrentName" value="{{ $value }}" /> 
                                <button onclick="$('#posterImage').click();" type="button" class="form-control" id="Video_Uploader">Upload image</button>
                            </div>
                        </div>
                        <div class="row img_container">
                            <div class="img_holder">
                                <img id="imgPlaceholder" src="{{ asset("/images/" . $value) }}" alt="">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary">Sumbit</button>
                </div>
            </div>
        </form>
    </div>


@endsection