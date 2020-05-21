<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatePlanningModel;
use App\Models\ReviewModel;
use App\ApiConnector\DatePlanningApiHandler;
use App\ApiConnector\ReviewApiHandler;
use App\ApiConnector\StageApiHandler;
use App\ApiConnector\GenreApiHandler;

class EventDateController extends Controller
{
    public function EventDate($id)
    {
        $DatePlanningApiHandler = new DatePlanningApiHandler();
        $stageApiHandler = new StageApiHandler();
        $genreApiHandler = new GenreApiHandler();
        $reviewApiHandler = new ReviewApiHandler();

        $data = $DatePlanningApiHandler->GetDatePlanningWithDetails($id);
        $data->event_date->stages = $stageApiHandler->GetByEventDate($data->event_date->id);
        $data->event->genre = $genreApiHandler->GetByEvent($data->eventid);
        $data->event_date->reviews = $reviewApiHandler->GetByEventDate($data->event_date->id);

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
