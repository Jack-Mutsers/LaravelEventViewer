<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Models\DatePlanningModel;
use App\Models\ReviewModel;
use App\ApiConnector\EventApiHandler;
use App\ApiConnector\ReviewApiHandler;

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
        $eventApiHandler = new EventApiHandler();

        $data = $eventApiHandler->GetEvent($id);
        
        $EventModel = new EventModel();
        $EventModel->FillWithData($data);

        //dd($EventModel);

        return view("event", ["event" => $EventModel]);
    }

    public function EventDate($id)
    {
        $eventApiHandler = new EventApiHandler();

        $data = $eventApiHandler->GetDatePlanning($id);

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
