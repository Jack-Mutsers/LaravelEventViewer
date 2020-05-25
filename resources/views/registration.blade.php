@extends('layouts.app')

@section('content')

<?php 
    $userData = Session::has('input') ? Session::get('input') : false;
    //$test = $input->sdfasdfds;
?>

    <link href="{{ asset('css/registration.css') }}" rel="stylesheet">
    <script src="{{ asset('js/registration.js') }}"></script>

    <div class="content-container">
        @include('tools.flash-message')
        <div class="row" id="content-header"><h1>Registration form</h1></div>
        <br><br>
        <div id="content-form">
            <form action="NewRegister" method="post">
                @CSRF
                <div class="row form-group">
                    <div class="col-md-2"><label for="name">* Name:</label></div>
                    <div class="col-md-10">
                        <?php $value = isset($userData->name) ? $userData->name : ""; ?>
                        <input class="form-control" required type="text" name="name" id="name" value="{{$value}}">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-2"><label for="username">* Username:</label></div>
                    <div class="col-md-10">
                        <?php $value = isset($userData->username) ? $userData->username : ""; ?>
                        <input class="form-control" required type="text" name="username" id="username" value="{{$value}}">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-2"><label for="password">* Password:</label></div>
                    <div class="col-md-10">
                        <input class="form-control" required type="password" name="password" id="password">
                        <input type="checkbox" id="pwShow"><label for="pwShow">&nbsp; Show Password</label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-2"><label>Preference:</label></div>
                    <div class="col-md-10">
                        <?php $json = isset($userData->preference) && is_array($userData->preference) ? json_encode($userData->preference) : ""; ?>
                        <input class="form-control" type="hidden" name="preference" id="preference" value="{{$json}}">
                        <div id="preference-container">
                            <?php $values = isset($userData->preference) && is_array($userData->preference) ? $userData->preference : array(); ?>
                            @foreach($genres as $genre)
                                <div class="preferenceSelector <?php echo in_array($genre->id, array_column($values, 'genre_id'))? 'selected' : ""; ?>" data-genre="{{$genre->id}}">{{$genre->name}}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row  form-group"> 
                    <div class="col-md-12"> 
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection