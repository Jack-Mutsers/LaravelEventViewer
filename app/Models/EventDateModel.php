<?php

namespace App\Models;

class EventDateModel
{
    public $id;
    public $event_id;
    public $planning_id;
    public $location;
    public $poster;
    public $images;
    public $videos;
    public $order_link;
    public $event;
    public $datePlanning;
    public $stages = [];
    public $reviews = [];
    public $artists = [];

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if(key_exists($key, $this)){
                if($key == "stages" && $val != null){
                    $stageModel = new StageModel();
                    $this->$key = $stageModel->FillWithDataArray($val);
                }
                else if($key == "event" && $val != null){
                    $eventModel = new EventModel();
                    $this->$key = $eventModel->FillWithData($val);
                }
                else if($key == "datePlanning" && $val != null){
                    $datePlanningModel = new DatePlanningModel();
                    $this->$key = $datePlanningModel->FillWithData($val);
                }
                else if($key == "reviews" && $val != null){
                    $reviewModel = new ReviewModel();
                    $this->$key = $reviewModel->FillWithDataArray($val);
                }
                else if($key == "artists" && $val != null){
                    $artistModel = new ArtistModel();
                    $this->$key = $artistModel->FillWithDataArray($val);
                }
                else{
                    $this->$key = $val;
                }    
            }
        }

        return $this;
    }

    public function FillWithDataArray($data = false)
    {
        if(!$data){
            return;
        }

        $array = [];
        foreach($data as $key => $val){
            $self = new self();
            $instance = $self->FillWithData($val);
            array_push($array, $instance);
        }

        return $array;
    }
}
