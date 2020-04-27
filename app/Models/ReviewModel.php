<?php

namespace App;

class ReviewModel
{
    public $id;
    public $event_date_id;
    public $user_id;
    public $review;
    public $validated;

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