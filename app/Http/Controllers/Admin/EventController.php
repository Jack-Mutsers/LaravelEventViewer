<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiConnector\EventApiHandler;
use App\ApiConnector\GenreApiHandler;
use App\ApiConnector\EventDateApiHandler;
use App\Models\EventModel;
use App\Models\DatePlanningModel;
use App\Models\GenreModel;

class EventController extends Controller
{
    public function index()
    {
        return view("admin.events");
    }

    

	public function Event($event_id = false)
	{
		$eventModel = new EventModel();
		$genreApiHandler = new GenreApiHandler();
		$eventApiHandler = new EventApiHandler();

		$name = "";
		if($event_id){
			$event_data = $eventApiHandler->GetEvent($event_id);
	
			$event_data->genre = $genreApiHandler->GetByEvent($event_id);

			$eventModel->FillWithData($event_data);
			$name = "Update Event";
		}else{
			$name = "Add New Event";
		}
		
		$genre_data = $genreApiHandler->GetAllGenres();

		$genreModel = new GenreModel();
		$genres = $genreModel->FillWithDataArray($genre_data);

		return view("admin.event", ["event" => $eventModel, "name" => $name, "genres" => $genres]);
	}

	public function DeleteEvent($event_id)
	{
		$eventApiHandler = new EventApiHandler();
		$success = $eventApiHandler->DeleteEvent($event_id);

		if(is_bool($success) && $success === true){
			return back()->with(["success" => "The Event has been deleted successfuly"]);
		}

		$error = $success;
		if(!is_string($success)){
			foreach($success->errors as $val){
				$error = $val[0];
			}
		}

		return back()->with(["input" => $eventModel])->withErrors('failure', $error);
	}


	public function EventDateItems($event_name, $event_id)
	{
		return view("admin.dateplannings", ["event_name" => $event_name, "event_id" => $event_id]);
	}

	public function EventDate($id)
	{
		
	}

	public function SaveEvent(Request $request)
	{
		$eventModel = new EventModel();
		$eventModel->active = $request->active == "on"? true : false;
		$eventModel->name = $request->name;
		$eventModel->description = $request->description;
		$eventModel->poster = $this->GetImageObject($request);
		$eventModel->genre = $this->BuildEventGenre( json_decode($request->genre) );
		
		$eventApiHandler = new EventApiHandler();
		$success = $eventApiHandler->StoreNewEvent($eventModel);

		if(is_bool($success) && $success === true){
			return redirect("/admin/events")->with(["success" => "The Event has been added successfuly"]);
		}

		$error = $success;
		if(!is_string($success)){
			foreach($success->errors as $val){
				$error = $val[0];
			}
		}

		return back()->with(["input" => $eventModel])->withErrors('failure', $error);
	}

	public function BuildEventGenre($selectedGenreObject)
	{
		$genreArray = array();
		if(!empty($selectedGenreObject)){
			foreach($selectedGenreObject as $key => $val){
				$genreArray[$key] = $val;
			}
		}

		return $genreArray;
	}

	public function GetImageObject($request)
	{
		$oldName = $request->posterOldName;
		$CurrentName = $request->posterCurrentName;
		
		
		$image_object = "";
		if($oldName != $CurrentName){
			
			$posterData = isset($request->posterImage) && !empty($request->posterImage) ? $this->UploadImage($request, $request->posterImage) : array();
			
			if(isset($posterData["valid"]) && $posterData["valid"]){
				$image_object = $posterData["image_json"];

			}

		}else{

			$object = (object) array(
				'url' => "upload/" . $oldName,
				'name' => $oldName,
				'image' => true
			);

			$image_object = json_encode($object);
		}

		return $image_object;
	}

	public function UploadImage($request, $img)
	{
		$result = ['image_json' => '', 'error' => '', 'valid' => true];
		if($img != null){

			$image_name   = $img->getClientOriginalName();
			$image_name   = str_replace(" ", "_", $image_name);

			if($request->hasFile('posterImage')){
				if( $request->file('posterImage')->isValid()){
					if($this->ValidateImage($img)){
						$file_path = base_path() . "/upload";
						if($img->move($file_path, $image_name)){
							$image_object = (object) array(
								'url' => "upload/" . $image_name,
								'name' => $image_name,
								'image' => true
							);
		
							$result['image_json'] = json_encode($image_object);
						}
					}else{
						$result['valid'] = false;
						$result['error'] = 'file Has to be an image';
					}
				}else{
					$result['valid'] = false;
					$result['error'] = 'No image was uploaded';
				}
			}else{
				$result['valid'] = false;
				$result['error'] = 'no image was uploaded';
			}
		}
		return $result;
	}

	function ValidateImage($path){
		$a = getimagesize($path);
		$image_type = $a[2];
		
		if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
		{
			return true;
		}
		return false;
	}

	public function DeleteEventDate(Type $var = null)
	{
		$eventApiHandler = new EventApiHandler();
		$success = $eventApiHandler->DeleteEventDate($event_id);
	}

	function Datatable_Events(Request $request){
        $data = array();
        
        $eventApiHandler = new EventApiHandler();
		$items = $eventApiHandler->GetAllEvents();

		$data['recordsTotal'] = count($items);
		$data['recordsFiltered'] = count($items);

		$tabledata = array();

		if (! empty($items))
		{
			foreach ($items as $item)
			{
                $row = array();
                
				$row[] = ($item->active == 1) ? "<i class=\"fa fa-check text-green\"></i>" : "<i class='fa fa-times text-red'></i>";
				$row[] = $item->name;

				$knoppen = '<a class="btn btn-sm btn-primary" href="/admin/event/' . $item->id . '" title="' . "Edit Item" . '" rel="tooltip"><i class="fa fa-pencil"></i></a>';
				$knoppen .= ' <a class="btn btn-sm btn-primary" href="/admin/eventdates/' . $item->name . '/' . $item->id . '" title="' . "Edit Item" . '" rel="tooltip"><i class="fa fa-list"></i></a>';
				$knoppen .= ' <a class="btn btn-sm btn-danger" href="#delete_modal" data-toggle="modal" onclick="$(\'#delete_modal .submit-modal\').attr(\'href\',\'/admin/event/delete/' . $item->id . '\');" title="' . "Delete Item" . '" rel="tooltip"><i class="fa fa-trash"></i></a>';

				$row[] = $knoppen;

				$tabledata[] = $row;
			}
		}

		$data['data'] = $tabledata;
		echo json_encode($data);
	}

	function Datatable_Plannings(Request $request){
        $data = array();
		
		$event_id = $request->event_id;

        $eventApiHandler = new EventApiHandler();
		$items = $eventApiHandler->GetEventDates($request->event_id);

		$data['recordsTotal'] = Count($items);
		$data['recordsFiltered'] = Count($items);

		$tabledata = array();

		if (! empty($items))
		{
			foreach ($items as $item)
			{
                $row = array();
                
				$row[] = ($item->event_date->active == 1) ? "<i class=\"fa fa-check text-green\"></i>" : "<i class='fa fa-times text-red'></i>";
				$row[] = $item->event_date->location;
				$row[] = (new \DateTime($item->start))->format("Y-m-d H:i:s");
				$row[] = (new \DateTime($item->end))->format("Y-m-d H:i:s");

				$knoppen = '<a class="btn btn-sm btn-primary" href="/admin/eventdate/' . $item->id . '" title="' . "Edit Item" . '" rel="tooltip"><i class="fa fa-pencil"></i></a>';
				$knoppen .= ' <a class="btn btn-sm btn-danger" href="#delete_modal" data-toggle="modal" onclick="$(\'#delete_modal .submit-modal\').attr(\'href\',\'/admin/eventdate/delete/' . $item->id . '\');" title="' . "Delete Item" . '" rel="tooltip"><i class="fa fa-trash"></i></a>';

				$row[] = $knoppen;

				$tabledata[] = $row;
			}
		}

		$data['data'] = $tabledata;
		echo json_encode($data);
	}
}
