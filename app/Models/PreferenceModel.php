<?php

namespace App\Models;

class PreferenceModel
{
    public $genre_id;
    public $genre;

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        foreach($data as $key => $val){
            if($key == "genre" && $val != null){
                $genreModel = new GenreModel();
                $this->$key = $genreModel->FillWithData($val);
            }
            else{
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