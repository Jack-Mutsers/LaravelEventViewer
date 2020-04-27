<?php

namespace App;

class ScheduleModel
{
    public $id;
    public $stage_id;
    public $event_id;
    public $datetime;

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