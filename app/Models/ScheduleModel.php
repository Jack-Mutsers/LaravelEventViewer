<?php

namespace App\Models;

class ScheduleModel
{
    public $id;
    public $stage_id;
    public $event_id;
    public $datetime;
    public $scheduleItems = [];

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if(key_exists($key, $this)){
                if($key == "scheduleItems" && $val != null){
                    $scheduleItemModel = new ScheduleItemModel();
                    $this->$key = $scheduleItemModel->FillWithDataArray($val);
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