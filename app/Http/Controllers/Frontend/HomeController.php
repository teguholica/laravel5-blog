<?php namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Models\PostModel;

class HomeController extends FrontendController {

	public function index()
	{
		$data['posts'] = PostModel::where('is_publish', 1)
				->where('show_in_home', 1)
				->orderBy('created_at','DESC')
				->paginate(15);
				
		return $this->loadView('index', $data);
	}

}
