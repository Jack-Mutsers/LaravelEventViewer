@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/registration.css') }}" rel="stylesheet">
    <script src="{{ asset('js/registration.js') }}"></script>

    <div class="content-container">
        <div class="row" id="content-header"><h1>Registration form</h1></div>
        <br><br>
        <div id="content-form">
            <form action="NewRegister" method="post">
                @CSRF
                <div class="row form-group">
                    <div class="col-md-2"><label for="name">Name:</label></div>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="name" id="name">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-2"><label for="username">Username:</label></div>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="username" id="username">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-2"><label for="password">Password:</label></div>
                    <div class="col-md-10">
                        <input class="form-control" type="password" name="password" id="password">
                        <input type="checkbox" id="pwShow"><label for="pwShow">&nbsp; Show Password</label>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-2"><label>Preference:</label></div>
                    <div class="col-md-10">
                        <input class="form-control" type="hidden" name="preference" id="preference">
                        <div id="preference-container">
                            @foreach($genres as $genre)
                                <div class="preferenceSelector" data-genre="{{$genre->id}}">{{$genre->name}}</div>
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