<?php namespace App\Http\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\CommentModel;
use SocialLinks\Page;
use Validator;
use Input;

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
	
	public function category($categorySlug){
		$data['category'] = CategoryModel::where('slug', $categorySlug)->first();
		if(is_null($data['category'])){
			abort(404);
		}
		$data['posts'] = $data['category']->post()->orderBy('created_at','DESC')->paginate(5);
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
			];		}
		return $this->loadView('category', $data);
	}
	
	public function tag($tagSlug){
		$data['tag'] = TagModel::where('slug', $tagSlug)->first();
		if(is_null($data['tag'])){
			abort(404);
		}
		$data['posts'] = $data['tag']->post()
			->where('is_publish', 1)
			->orderBy('updated_at','DESC')
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
		return $this->loadView('tag', $data);
	}

	public function search(){
		$data['searchQuery'] = Input::get('q');
		$data['posts'] = PostModel::where('title', 'like', '%'.Input::get('q').'%')
			->orWhere('content', 'like', '%'.Input::get('q').'%')
			->where('is_publish', 1)
			->orderBy('updated_at','DESC')
			->paginate(10);
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
		return $this->loadView('search', $data);
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