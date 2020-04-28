<?php

namespace App\Models;

class ScheduleItemModel
{
    public $id;
    public $schedule_id;
    public $artist_id;
    public $stage_time;
    public $artists;

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if($key == "artists" && $val != null){
                $artistModel = new ArtistModel();
                $this->$key = $artistModel->FillWithDataArray($val);
            }else{
                $this->$key = $val;
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