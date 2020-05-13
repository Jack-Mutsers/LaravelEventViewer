@extends('layouts.adminapp')

@section('content')


    <div class="container">
        <h1>{{$name}}</h1>
        
        <div class="row" id="content-schedule">
            <!-- foldable stages + schedule -->
            <ul class="nav nav-pills">
                <li><a class="active nav_link" data-toggle="tab" href="#general_tab"><span class="boldTitle">General</span></a></li>
                <li><a class="nav_link" data-toggle="tab" href="#poster_tab"><span class="boldTitle">Poster</span></a></li>
                <li><a class="nav_link" data-toggle="tab" href="#images_tab"><span class="boldTitle">Images</span></a></li>
                <li><a class="nav_link" data-toggle="tab" href="#videos_tab"><span class="boldTitle">Videos</span></a></li>
            </ul>

            <form action="createEvent" method="post">
                <div class="col-md-12 box tab-content">

                    <div id="general_tab" class="tab-pane fade in active show">

                    </div>

                    <div id="poster_tab" class="tab-pane fade">

                    </div>

                    <div id="images_tab" class="tab-pane fade">
                        
                    </div>

                    <div id="videos_tab" class="tab-pane fade">

                    </div>

                </div>
            </form>
        </div>
    </div>


@endsection