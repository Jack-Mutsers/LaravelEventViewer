<?php

namespace App\Models;

class ScheduleItemModel
{
    public $id;
    public $schedule_id;
    public $artist_id;
    public $start;
    public $stage_time;
    public $artist;

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if($key == "artists" && $val != null){
                $artistModel = new ArtistModel();
                $this->$key = $artistModel->FillWithDataArray($val);
            }else if($key == "start" && $val != null){
                $this->$key  = new \DateTime($val);
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

        usort($data, $this->build_sorter('start'));

        $array = [];
        foreach($data as $key => $val){
            $self = new self();
            $instance = $self->FillWithData($val);
            array_push($array, $instance);
        }

        return $array;
    }

    public function build_sorter($key) {
        return function ($a, $b) use ($key) {
            return strnatcmp($a->$key, $b->$key);
        };
    }
}