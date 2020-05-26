<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Models\GenreModel;
use App\ApiConnector\ArtistApiHandler;
use App\ApiConnector\EventApiHandler;
use App\ApiConnector\DatePlanningApiHandler;
use App\ApiConnector\GenreApiHandler;

class EventController extends Controller
{
    public function index(){
        //$events = $this->dummyEvents();
        $eventApiHandler = new EventApiHandler();
        $genreApiHandler = new GenreApiHandler();

        $genreData = $genreApiHandler->GetAllGenres();
        $data = $eventApiHandler->GetAllActiveEvents();
        
        $GenreModel = new GenreModel();
        $genres = $GenreModel->FillWithDataArray($genreData);
        
        $EventModel = new EventModel();
        $events = $EventModel->FillWithDataArray($data);

        return view('events', ["events" => $events, "genres" => $genres]);
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

    public function OrderEvents(Request $request)
    {
        $order_item = $request->order_item;
        $order_dir = $request->order_dir;
        $genre_id = (int) $request->genre;

        $eventApiHandler = new EventApiHandler();
        $data = $eventApiHandler->EventOrderRequest($order_item, $order_dir, $genre_id);
        
        echo json_encode($data);
    }

    public function GetEventsByGenre(Request $request)
    {
        $genre_id = (int) $request->genre;

        $eventApiHandler = new EventApiHandler();
        $data = $eventApiHandler->GetEventsByGenre($genre_id);
        
        echo json_encode($data);
    }

    public function GetEventByName(Request $request)
    {
        $name = $request->name;

        $eventApiHandler = new EventApiHandler();
        $data = $eventApiHandler->GetEventByName($name);
        
        echo json_encode($data);
    }

    public function GetAllActiveEvents()
    {
        $eventApiHandler = new EventApiHandler();
        $data = $eventApiHandler->GetAllActiveEvents();
        
        echo json_encode($data);
    }
}
