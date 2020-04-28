<?php

namespace App\Models;

use Illuminate\Http\Request;

class EventModel
{
    public $id;
    public $active = true;
    public $name;
    public $description;
    public $poster;
    public $genre_id;
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
                    $genreModel = new GenreModel();
                    $this->$key = $genreModel->FillWithDataArray($val);
                }
                else if($key == "next" && $val != null){
                    $datePlanningModel = new DatePlanningModel();
                    $this->$key = $datePlanningModel->FillWithData($val);
                }
                else if($key == "finished" && $val != null){
                    $datePlanningModel = new DatePlanningModel();
                    $this->$key = $datePlanningModel->FillWithDataArray($val);
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