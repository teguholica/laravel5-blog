<?php namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Models\CategoryModel;

class CategoryController extends FrontendController {

	public function index($categorySlug)
	{
		$data['category'] = CategoryModel::where('slug', $categorySlug)->first();

		if(is_null($data['category'])){
			abort(404);
		}

		$data['posts'] = $data['category']->post()->orderBy('created_at','DESC')->paginate(5);
		
		return $this->loadView('category', $data);
	}

}
