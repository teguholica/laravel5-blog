<?php namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Models\TagModel;

class TagController extends FrontendController {

	private $pageNum = 15;

	public function index($tagSlug){
		$data['tag'] = TagModel::where('slug', $tagSlug)->first();

		if(is_null($data['tag'])){
			abort(404);
		}

		$data['posts'] = $data['tag']->post()
			->where('is_publish', 1)
			->orderBy('updated_at','DESC')
			->paginate($this->pageNum);

		return $this->loadView('tag', $data);
	}

}
