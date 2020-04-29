<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Models\EventDateModel;
use App\ApiConnector\EventApiHandler;

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

        $data = $eventApiHandler->GetEventDate($id);

        $eventDateModel = new EventDateModel();
        $eventDateModel->FillWithData($data);

        //dd($eventDateModel);
        return view("eventDate", ["eventdate" => $eventDateModel]);
    }

}
