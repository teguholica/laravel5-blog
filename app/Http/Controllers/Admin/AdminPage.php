<?php namespace App\Http\Controllers;

class AdminPage extends Controller {

	protected function loadView($view, $appendData){
		return view('AdminTemplate.'.$view, $data);
	}

}