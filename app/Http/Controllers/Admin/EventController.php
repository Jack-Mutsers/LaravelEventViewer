<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiConnector\EventApiHandler;

class EventController extends Controller
{
    public function index()
    {
        return view("admin.events");
    }

    function datatable_ajax(Request $request){
        $data = array();
        
		$search = $request->search ? $request->search : false;
		$search = $search ? trim($search["value"]) : ""; // remove unwanted spaces at the start + end of the search

		$limitstart = $request->start == null ? 0 : $request->start;
		$limitlength = $request->length == null ? 10 : $request->length;

        $eventApiHandler = new EventApiHandler();
		$items = $eventApiHandler->GetDataTable($search, $limitstart, $limitlength);

		$data['recordsTotal'] = $items->total;
		$data['recordsFiltered'] = $items->totalfilter;

		$tabledata = array();

		if (! empty($items->data))
		{
			foreach ($items->data as $item)
			{
                $row = array();
                
				$row[] = ($item->active == 1) ? "<i class=\"fa fa-check text-green\"></i>" : "<i class='fa fa-times text-red'></i>";
				$row[] = $item->name;

				$knoppen = '<a class="btn btn-sm btn-primary" href="/admin/event/' . $item->id . '" title="' . "Edit Item" . '" rel="tooltip"><i class="fa fa-pencil"></i></a>';
				$knoppen .= ' <a class="btn btn-sm btn-danger" href="#delete_modal" data-toggle="modal" onclick="$(\'#delete_modal .submit-modal\').attr(\'href\',\'/admin/event/delete/' . $item->id . '\');" title="' . "Delete Item" . '" rel="tooltip"><i class="fa fa-trash"></i></a>';

				$row[] = $knoppen;

				$tabledata[] = $row;
			}
		}

		$data['data'] = $tabledata;
		echo json_encode($data);
	}


}
