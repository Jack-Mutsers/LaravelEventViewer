<?php 

namespace App\Helpers;

use Illuminate\Http\Request;
use File;
use Response;

class Helper
{
    
	public static function GetImageObject($request){
		$oldName = $request->posterOldName;
		$CurrentName = $request->posterCurrentName;
		
		
		$image_object = "";
		if($oldName != $CurrentName){
			
			$posterData = isset($request->posterImage) && !empty($request->posterImage) ? Helper::UploadImage($request, $request->posterImage) : array();
			
			if(isset($posterData["valid"]) && $posterData["valid"]){
				$image_object = $posterData["image_json"];

			}

		}else{

			$object = (object) array(
				'url' => "images/" . $oldName,
				'name' => $oldName,
				'image' => true
			);

			$image_object = json_encode($object);
		}

		return $image_object;
	}

	private static function UploadImage($request, $img){
		$result = ['image_json' => '', 'error' => '', 'valid' => true];
		if($img != null){

			$image_name   = $img->getClientOriginalName();
			$image_name   = str_replace(" ", "_", $image_name);

			if($request->hasFile('posterImage')){
				if( $request->file('posterImage')->isValid()){
					if(Helper::ValidateImage($img)){
						$file_path = base_path() . "/public/images/";
						if($img->move($file_path, $image_name)){
							$image_object = (object) array(
								'url' => "images/" . $image_name,
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

	private static function ValidateImage($path){
		$a = getimagesize($path);
		$image_type = $a[2];
		
		if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
		{
			return true;
		}
		return false;
	}

	public static function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}