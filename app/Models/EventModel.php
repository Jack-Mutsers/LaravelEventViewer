<?php

namespace App\Models;

use Illuminate\Http\Request;
use Helper;

class EventModel
{
    public $id;
    public $active = true;
    public $name;
    public $description;
    public $poster;
    public $genre_id;
    public $genre = [];
    public $next;
    public $finished = [];

    public function FillWithData($data = false)
    {
        if(!$data){
            return;
        }

        $this->test();
        foreach($data as $key => $val){
            if(key_exists($key, $this)){
                if($key == "genre" && $val != null){
                    $eventGenreModel = new EventGenreModel();
                    $this->$key = $eventGenreModel->FillWithDataArray($val);
                }
                else if($key == "next" && $val != null){
                    $datePlanningModel = new DatePlanningModel();
                    $this->$key = $datePlanningModel->FillWithData($val);
                }
                else if($key == "finished" && $val != null){
                    $datePlanningModel = new DatePlanningModel();
                    $this->$key = $datePlanningModel->FillWithDataArray($val);
                }
                //else if($key == "poster" && $val != null){
                //    $object = json_decode($val);
                //    $this->$key = Helper::displayImage($object->name);
                //}
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
 
    public function test()
    {
        $object1 = (object) array(
            "url" => "Upload/Camera.jpg",
            "name" => "Camera.jpg",
            "image" => true
        );

        $object2 = (object) array(
            "url" => "Upload/tree.jpg",
            "name" => "tree.jpg",
            "image" => true
        );

        $object3 = (object) array(
            "url" => "Upload/india.jpg",
            "name" => "india.jpg",
            "image" => true
        );

        $object4 = (object) array(
            "url" => "Upload/boat.jpg",
            "name" => "boat.jpg",
            "image" => true
        );

        $objectlist = array();

        array_push($objectlist, $object1);
        array_push($objectlist, $object2);
        array_push($objectlist, $object3);
        array_push($objectlist, $object4);
        
        array_push($objectlist, $object2);
        array_push($objectlist, $object3);
        array_push($objectlist, $object4);
        array_push($objectlist, $object1);

        array_push($objectlist, $object3);
        array_push($objectlist, $object4);
        array_push($objectlist, $object1);
        array_push($objectlist, $object2);
        
        array_push($objectlist, $object4);
        array_push($objectlist, $object1);
        array_push($objectlist, $object2);
        array_push($objectlist, $object3);

        $test = json_encode($objectlist);
        //dd($test);
    }
}