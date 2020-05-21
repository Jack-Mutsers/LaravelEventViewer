<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\ApiConnector\ArtistApiHandler;
use App\ApiConnector\EventApiHandler;
use App\ApiConnector\DatePlanningApiHandler;
use App\ApiConnector\GenreApiHandler;

class EventController extends Controller
{
    public function index(){
        //$events = $this->dummyEvents();
        $eventApiHandler = new EventApiHandler();

        $data = $eventApiHandler->GetAllEvents();
        
        $EventModel = new EventModel();
        $events = $EventModel->FillWithDataArray($data);

        return view('events', ["events" => $events]);
    }

    public function Event($id)
    {
        $artistApiHandler = new ArtistApiHandler();
        $eventApiHandler = new EventApiHandler();
        $DatePlanningApiHandler = new DatePlanningApiHandler();
        $genreApiHandler = new GenreApiHandler();

        $data = $eventApiHandler->GetEventWithDetails($id);
        $data->genre = $genreApiHandler->GetByEventWithDetails($data->id);
        $data->next = $DatePlanningApiHandler->GetNextEventDate($data->id);
        $data->next->event_date->artists = $artistApiHandler->GetArtistsByEventDate($data->next->event_date->id);
        $data->finished = $DatePlanningApiHandler->GetFinishedEvents($data->id);

        $EventModel = new EventModel();
        $EventModel->FillWithData($data);

        //dd($EventModel);

        return view("event", ["event" => $EventModel]);
    }


}
