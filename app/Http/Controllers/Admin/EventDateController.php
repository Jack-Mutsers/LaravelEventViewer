<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiConnector\DatePlanningApiHandler;
use App\Models\DatePlanningModel;

class EventDateController extends Controller
{
    public function index($event_name, $event_id)
	{
		return view("admin.dateplannings", ["event_name" => $event_name, "event_id" => $event_id]);
	}

	public function EventDate($id)
	{
		
	}

	public function DeleteEventDate($event_date_id)
	{
		$DatePlannerApiHandler = new DatePlannerApiHandler();
		$success = $DatePlannerApiHandler->DeleteEventDate($event_date_id);

		if(is_bool($success) && $success === true){
			return back()->with(["success" => "The EventDate has been deleted successfuly"]);
		}

		$error = $success;
		if(!is_string($success)){
			foreach($success->errors as $val){
				$error = $val[0];
			}
		}

		return back()->withErrors('failure', $error);
	}

	public function SaveEventDate(Request $request)
	{

	}

	function Datatable_Plannings(Request $request){
        $data = array();
		
		$event_id = $request->event_id;

        $datePlanningApiHandler = new DatePlanningApiHandler();
		$items = $datePlanningApiHandler->GetEventDates($request->event_id);

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
