<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiConnector\EventApiHandler;
use App\ApiConnector\GenreApiHandler;
use App\Models\EventModel;
use App\Models\GenreModel;
use App\Models\EventGenreModel;
use Helper;

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

		return back()->withErrors('failure', $error);
	}

	public function SaveEvent(Request $request)
	{
		$eventGenreModel = new EventGenreModel();

		$eventModel = new EventModel();
		$eventModel->active = $request->active == "on"? true : false;
		$eventModel->name = $request->name;
		$eventModel->description = $request->description;
		$eventModel->poster = Helper::GetImageObject($request);
		$eventModel->genre = $eventGenreModel->FillWithDataArray( json_decode($request->genre) );
		
		$eventApiHandler = new EventApiHandler();

		$message = "";
		if(isset($request->id) && !empty($request->id)){
			$eventModel->id = (int)$request->id;
			$success = $eventApiHandler->UpdateEvent($eventModel);
			$message = "The Event has been updated successfuly";
		}
		else{
			$success = $eventApiHandler->StoreNewEvent($eventModel);
			$message = "The Event has been added successfuly";
		}

		if(is_bool($success) && $success === true){
			return redirect("/admin/events")->with(["success" => $message]);
		}

		$error = $success;
		if(!is_string($success)){
			foreach($success->errors as $val){
				$error = $val[0];
			}
		}

		return back()->with(["input" => $eventModel])->withErrors('failure', $error);
	}

	public function Datatable_Events(Request $request){
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
}
