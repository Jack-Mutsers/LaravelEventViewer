<?php

namespace App\Models;

class DatePlanningModel
{
    public $id;
    public $event_id;
    public $start;
    public $end;
    public $event_date;

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if(key_exists($key, $this)){
                if($key == "event_date" && $val != null){
                    $eventDateModel = new EventDateModel();
                    $this->$key = $eventDateModel->FillWithData($val);
                }
                else if($key == "start" && $val != null){
                    $this->$key  = new \DateTime($val);
                }
                else if($key == "end" && $val != null){
                    $this->$key  = new \DateTime($val);
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