<?php namespace App\Http\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use SocialLinks\Page;

class BlogController extends FrontendController {

	public function index(){
		$data['posts'] = PostModel::where('is_publish', 1)
				->where('show_in_home', 1)
				->orderBy('created_at','DESC')
				->paginate(5);
		foreach($data['posts'] as $post){
			$page = new Page([
			    'url' => route('blog.show', $post->slug),
			    'title' => $post->title,
			    'text' => $post->title,
			    'image' => '',
			    'twitterUser' => '@teguholica'
			]);

			$link = '<a href="%s">%s (%s)</a>';

			$post->share = (Object)[
				'gplus' => $page->plus->shareUrl,
				'facebook' => $page->facebook->shareUrl,
				'twitter' => $page->twitter->shareUrl
			];
		}
		return $this->loadView('index', $data);
	}

	public function show($slug){
		$data['comments'] = PostModel::where('slug', $slug)->first()->comment;
		$data['post'] = PostModel::where('is_publish', 1)->where('slug', $slug)->first();
		if(count($data['post']) > 0){
			$data['post']->share = (object)Share::load(route('blog.show', $data['post']->slug), $data['post']->title)->services('facebook', 'gplus', 'twitter', 'gmail');
		}
		return $this->loadView('show', $data);
	}
	
	public function category($categorySlug){
		$data['posts'] = CategoryModel::where('slug', $categorySlug)->first()->post()->orderBy('created_at','DESC')->paginate(5);
		foreach($data['posts'] as $post){
			$post->share = (object)Share::load(route('blog.show', $post->slug), $post->title)->services('facebook', 'gplus', 'twitter', 'gmail');
		}
		return $this->loadView('category', $data);
	}
	
	public function tag($tagSlug){
		$data['tagSlug'] = $tagSlug;
		$data['posts'] = TagModel::where('slug', $tagSlug)->first()->post()
			->where('is_publish', 1)
			->orderBy('updated_at','DESC')
			->paginate(5);
		foreach($data['posts'] as $post){
			$post->share = (object)Share::load(route('blog.show', $post->slug), $post->title)->services('facebook', 'gplus', 'twitter', 'gmail');
		}
		return $this->loadView('tag', $data);
	}

	public function search(){
		$data['posts'] = PostModel::where('title', 'like', '%'.Input::get('q').'%')
			->orWhere('content', 'like', '%'.Input::get('q').'%')
			->where('is_publish', 1)
			->orderBy('updated_at','DESC')
			->paginate(10);
		foreach($data['posts'] as $post){
			$post->share = (object)Share::load(route('blog.show', $post->slug), $post->title)->services('facebook', 'gplus', 'twitter', 'gmail');
		}
		return $this->loadView('search', $data);
	}

	public function storeComment($postId)
	{
		$rules = array('name' => 'required', 'content' => 'required');
		$input = Input::all();
		$validation = Validator::make($input, $rules);
		if ($validation -> passes()) {
			$comment = PostModel::find($postId)->comment()->create($input);
			return Redirect::route('blog.show', $comment->post->slug);
		}else{
			return Redirect::route('blog.show', $comment->post->slug);
		}
	}

}