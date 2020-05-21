<?php

namespace App\Models;

use Illuminate\Http\Request;
use Helper;

class EventModel
{
    public $id;
    public $active = true;
    public $name;
    public $description;
    public $poster;
    public $genre = [];
    public $next;
    public $finished = [];

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if(key_exists($key, $this)){
                if($key == "genre" && $val != null){
                    $eventGenreModel = new EventGenreModel();
                    $this->$key = $eventGenreModel->FillWithDataArray($val);
                }
                else if($key == "next" && $val != null){
                    $datePlanningModel = new DatePlanningModel();
                    $this->$key = $datePlanningModel->FillWithData($val);
                }
                else if($key == "finished" && $val != null){
                    $datePlanningModel = new DatePlanningModel();
                    $this->$key = $datePlanningModel->FillWithDataArray($val);
                }
                //else if($key == "poster" && $val != null){
                //    $object = json_decode($val);
                //    $this->$key = Helper::displayImage($object->name);
                //}
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