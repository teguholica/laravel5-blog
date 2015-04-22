<?php namespace App\Http\Controllers;

use App\Libs\Image;
use Input;

class ImagePlaceholderController extends Controller {

	public function loadView(){
		return Image::placeholder(Input::get("h"), Input::get("w"), Input::get("t"));
	}

}