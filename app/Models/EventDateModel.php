<?php

namespace App;

class EventDateModel
{
    public $id;
    public $event_id;
    public $planning_id;
    public $location;
    public $images;
    public $videos;

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            $this->$key = $val;
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
           array_push(FillWithData($val), $array);
        }

        return $array;
    }
}
