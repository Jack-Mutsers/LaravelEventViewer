<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
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


        var_dump($EventModel);
    }

    private function dummyEvents(){
        $dummyData = [
            [
                "id" => 1,
                "active" => true,
                "name" => "event 1",
                "description" => "this is a description",
                "poster" => "https://product-image.juniqe-production.juniqe.com/media/catalog/product/cache/x800/740/9/740-9-101P.jpg",
                "genre_id" => 1,
            ],
            [
                "id" => 2,
                "active" => true,
                "name" => "event 2",
                "description" => "this is a description",
                "poster" => "https://product-image.juniqe-production.juniqe.com/media/catalog/product/cache/x800/740/9/740-9-101P.jpg",
                "genre_id" => 2,
            ],
            [
                "id" => 3,
                "active" => true,
                "name" => "event 3",
                "description" => "this is a description",
                "poster" => "https://product-image.juniqe-production.juniqe.com/media/catalog/product/cache/x800/740/9/740-9-101P.jpg",
                "genre_id" => 3,
            ],
            [
                "id" => 4,
                "active" => true,
                "name" => "event 4",
                "description" => "this is a description",
                "poster" => "https://product-image.juniqe-production.juniqe.com/media/catalog/product/cache/x800/740/9/740-9-101P.jpg",
                "genre_id" => 4,
            ],
        ];

        $test = new EventModel();
        return $test->FillWithDataArray($dummyData);
    }
}
