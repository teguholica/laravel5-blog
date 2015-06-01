<?php namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Models\PostModel;

class SearchController extends FrontendController {

	private $pageNum = 15;

	public function index(Request $request)
	{
		$searchQuery = $request->get('q');

		$data['searchQuery'] = $searchQuery;

		$data['posts'] = PostModel::where('title', 'like', '%'.$searchQuery.'%')
			->orWhere('content', 'like', '%'.$searchQuery.'%')
			->where('is_publish', 1)
			->orderBy('updated_at','DESC')
			->paginate($this->pageNum);

		return $this->loadView('search', $data);
	}

}
