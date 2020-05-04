<?php

namespace App\Models;

class GenreModel
{
    public $id;
    public $name;

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }
        
        $data = isset($data->genre) ? $data->genre : $data;

        foreach($data as $key => $val){
            if(key_exists($key, $this)){
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