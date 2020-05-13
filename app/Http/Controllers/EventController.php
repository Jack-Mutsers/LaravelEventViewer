<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Models\DatePlanningModel;
use App\Models\ReviewModel;
use App\ApiConnector\ArtistApiHandler;
use App\ApiConnector\EventApiHandler;
use App\ApiConnector\EventDateApiHandler;
use App\ApiConnector\ReviewApiHandler;
use App\ApiConnector\StageApiHandler;
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
        $eventDateApiHandler = new EventDateApiHandler();
        $genreApiHandler = new GenreApiHandler();

        $data = $eventApiHandler->GetEventWithDetails($id);
        $data->genre = $genreApiHandler->GetByEventWithDetails($data->id);
        $data->next = $eventDateApiHandler->GetNextEventDate($data->id);
        $data->next->event_date->artists = $artistApiHandler->GetArtistsByEventDate($data->next->event_date->id);
        $data->finished = $eventDateApiHandler->GetFinishedEvents($data->id);

        $EventModel = new EventModel();
        $EventModel->FillWithData($data);

        //dd($EventModel);

        return view("event", ["event" => $EventModel]);
    }

    public function EventDate($id)
    {
        $eventDateApiHandler = new EventDateApiHandler();
        $stageApiHandler = new StageApiHandler();
        $genreApiHandler = new GenreApiHandler();

        $data = $eventDateApiHandler->GetDatePlanning($id);
        $data->event_date->stages = $stageApiHandler->GetByEventDate($data->event_date->id);
        $data->event->genre = $genreApiHandler->GetByEvent($data->eventid);

        $datePlanningModel = new DatePlanningModel();
        $datePlanningModel->FillWithData($data);

        //dd($eventDateModel);
        return view("eventDate", ["datePlanning" => $datePlanningModel]);
    }

    public function AddReview(Request $request)
    {
        $reviewModel = new ReviewModel();
        $reviewModel->event_date_id = (int) $request->event_date_id;
        $reviewModel->user_id = (int) session("user")->id;
        $reviewModel->review = $request->review;
        $reviewModel->rating = (int) $request->rating;

        $reviewHandler = new ReviewApiHandler();
        $result = $reviewHandler->AddNew($reviewModel);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

}
