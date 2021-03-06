<?php

namespace App\Models;

class ReviewModel
{
    public $id;
    public $event_date_id;
    public $user_id;
    public $review;
    public $rating;
    public $validated;
    public $user;

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if(key_exists($key, $this)){
                if($key == "user" && $val != null){
                    $userModel = new UserModel();
                    $this->$key = $userModel->FillWithData($val);
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