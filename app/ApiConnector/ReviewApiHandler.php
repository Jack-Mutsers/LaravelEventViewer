<?php

namespace App\ApiConnector;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Models\GenreModel;

class ReviewApiHandler
{
    public function AddNew($reviewModel)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost:5000/api/review",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($reviewModel),
            CURLOPT_HTTPHEADER => array(
              "Content-Type: application/json"
            ),
          ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

}