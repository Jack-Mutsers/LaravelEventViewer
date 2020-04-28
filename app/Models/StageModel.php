<?php

namespace App\Models;

class StageModel
{
    public $id;
    public $event_date_id;
    public $name;
    public $schedule;

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if(key_exists($key, $this)){
                if($key == "schedule" && $val != null){
                    $scheduleModel = new ScheduleModel();
                    $this->$key = $scheduleModel->FillWithDataArray($val);
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