<?php

namespace App\Models;

class UserModel
{
    public $name;
    public $username;
    public $password;
    public $right_id;
    public $right;
    public $preference;

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if($key == "right" && $val != null){
                $userRightModel = new UserRightModel();
                $this->$key = $userRightModel->FillWithData($val);
            }else if($key == "preference" && $val != null){
                $preferenceModel = new PreferenceModel();
                $this->$key = $preferenceModel->FillWithDataArray($val);
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