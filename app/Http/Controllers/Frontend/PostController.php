<?php namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Models\PostModel;

use SocialLinks\Page;

class PostController extends FrontendController {

	public function index($slug)
	{
		$data['comments'] = PostModel::where('slug', $slug)->first()->comment;
		$data['post'] = PostModel::where('is_publish', 1)->where('slug', $slug)->first();

		if(count($data['post']) > 0){
			$data['post']->view = $data['post']->view + 1;
			$data['post']->save();

			$page = new Page([
			    'url' => route('blog.show', $data['post']->slug),
			    'title' => $data['post']->title,
			    'text' => $data['post']->title,
			    'image' => '',
			    'twitterUser' => '@teguholica'
			]);

			$link = '<a href="%s">%s (%s)</a>';

			$data['post']->share = (Object)[
				'gplus' => $page->plus->shareUrl,
				'facebook' => $page->facebook->shareUrl,
				'twitter' => $page->twitter->shareUrl
			];
		}
		return $this->loadView('show', $data);
	}

	public function storeComment($postId)
	{
		$rules = array('name' => 'required', 'content' => 'required');
		$input = Input::all();
		$validation = Validator::make($input, $rules);
		if ($validation -> passes()) {
			$comment = PostModel::find($postId)->comment()->create($input);
			return redirect()->route('blog.show', $comment->post->slug);
		}else{
			return redirect()->route('blog.show', $comment->post->slug);
		}
	}

}
