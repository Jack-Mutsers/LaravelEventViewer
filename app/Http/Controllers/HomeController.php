<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiConnector\EventApiHandler;
use App\Models\DatePlanningModel;

class HomeController extends Controller
{
    public function index(){
        $eventHandler = new EventApiHandler();
        $plannigData = $eventHandler->GetDatePlanning();
        $nextEventData = $eventHandler->GetNextEvent();

        $datePlanningModel = new DatePlanningModel();
        $dates = $datePlanningModel->FillWithDataArray($plannigData);
        $event = $datePlanningModel->FillWithData($nextEventData);

        $calendar = [];

        foreach($dates as $key => $val){
            $calendar_item = [
                "title" => $val->event->name,
                "url"   => "/Event/EventDate/" . $val->event_date->id,
                "start" => $val->start->format("Y-m-d H:i:s"),
                "end"   => $val->end->format("Y-m-d H:i:s"),
                "allDay" => false
            ];

            array_push($calendar, $calendar_item);
        }

        return view('home', ["DatePlanning" => $event, "calendar" => $calendar]);
    }


}
