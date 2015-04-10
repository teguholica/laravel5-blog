<?php

class ImagePlaceholderController extends BaseController {

	public function loadView(){
		return Image::placeholder(Input::get("h"), Input::get("w"), Input::get("t"));
	}

}