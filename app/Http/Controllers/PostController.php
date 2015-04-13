<?php namespace App\Http\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use Validator;
use Input;
use Auth;
use Sunra\PhpSimple\HtmlDomParser;
use App\Libs\Image;

class PostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['posts'] = PostModel::paginate(15);
		return view('admin.post.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data['categories'] = CategoryModel::all();
		$data['tags'] = TagModel::all();
		return view('admin.post.create', $data);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::get('isSaveToPost') == 'true'){
			return $this->saveToPost();
		}else{
			return $this->saveToServer();
		}
		
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data['post'] = PostModel::find($id);
		$data['categories'] = CategoryModel::all();
		$data['tags'] = TagModel::all();

		$data['selectedTags'] = array();
		foreach($data['post']->tag as $tag){
			$data['selectedTags'][] = $tag->pivot->tag_id;
		}

		return view('admin.post.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'title' => 'required', 
			'slug' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if ($validation->passes()){
			$input = Input::except('enable_preview_content', 'tags');
			$input['user_id'] = Auth::user()->id;
			
			if(!Input::has('enable_preview_content')){
				$input['preview_content'] = "";
			}
			
			$html = HtmlDomParser::str_get_html(Input::get('content'));
			foreach($html->find('img') as $key => $element){
				$imageEncode = preg_replace('#^data:image/[^;]+;base64,#', '', $element->src);
				$imageDecode = base64_decode($imageEncode);
				
				$file = Image::fromBase64($imageEncode, public_path('images/generate/'.date('YmdHis').$key));
				$imageSize = getimagesizefromstring($imageDecode);
				
				$element->class = 'lazy';
				$element->{"data-src"} = asset('images/generate/'.$file);
				$element->src = route('image_placeholder.load', array('h' => $imageSize[1], 'w' => $imageSize[0], 't' => 'Loading...'));
			}
			$html->save();
			$input["lazy_content"] = $html;
			
			try {
				$post = PostModel::find($id)->update($input);
			} catch (Exception $e) {
				if($e->getCode() == 23000){
					$failMsg = 'Post title is double. Please check again.';
				}else{
					$failMsg = $e->getMessage();
				}
				return redirect()->route('admin.post.edit', $id)
					->withInput()
					->with('fail_msg', $failMsg);
			}

			if(isset($post)){
				PostModel::find($id)->tag()->sync(Input::has('tags')?Input::get('tags'):array());
			}
			
			return redirect()->route('admin.post.index')
				-> with('success_msg', 'Succesfully edited post');
		}

		return redirect()->route('admin.post.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('fail_msg', 'Failed to edit post');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		PostModel::find($id)->delete();
		return redirect()->route('admin.post.index')
			->with('success_msg', 'Succesfully deleted post');
	}

	private function saveToServer(){
		$rules = array(
			'title' => 'required', 
			'slug' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if ($validation->passes()){
			$input = Input::except('enable_preview_content', 'tags', 'isSaveToPost');
			$input['user_id'] = Auth::user()->id;
			
			if(!Input::has('enable_preview_content')){
				$input['preview_content'] = "";
			}
			
			$html = HtmlDomParser::str_get_html(Input::get('content'));
			foreach($html->find('img') as $key => $element){
				$imageEncode = preg_replace('#^data:image/[^;]+;base64,#', '', $element->src);
				$imageDecode = base64_decode($imageEncode);
				
				$file = Image::fromBase64($imageEncode, public_path('images/generate/'.date('YmdHis').$key));
				$imageSize = getimagesizefromstring($imageDecode);
				
				$element->class = 'lazy';
				$element->{"data-src"} = asset('images/generate/'.$file);
				$element->src = route('image_placeholder.load', array('h' => $imageSize[1], 'w' => $imageSize[0], 't' => 'Loading...'));
			}
			$html->save();
			$input["lazy_content"] = $html;
			
			try {
				$post = PostModel::create($input);
			} catch (Exception $e) {
				if($e->getCode() == 23000){
					$failMsg = 'Post title is double. Please check again.';
				}else{
					$failMsg = $e->getMessage();
				}
				return redirect()->route('admin.post.create')
					->withInput()
					->with('fail_msg', $failMsg);
			}

			if(isset($post)){
				$post->tag()->sync(Input::has('tags')?Input::get('tags'):array());
			}
			
			return redirect()->route('admin.post.index')
				-> with('success_msg', 'Succesfully created new post');
		}

		return redirect()->route('admin.post.create')
			->withInput()
			->withErrors($validation)
			->with('fail_msg', 'Failed to create new post');
	}

	private function saveToPost(){
		$rules = array(
			'title' => 'required', 
			'slug' => 'required'
		);
		$validation = Validator::make(Input::all(), $rules);

		if ($validation->passes()){
			$input = Input::except('enable_preview_content', 'tags');
			$input['user_id'] = Auth::user()->id;
			
			if(!Input::has('enable_preview_content')){
				$input['preview_content'] = "";
			}

			header ("Content-Type: application/octet-stream");
			header ("Content-disposition: attachment; filename=".Input::get('slug').".post");
			return json_encode([
				"title" => Input::get('title'),
				"content" => Input::get('content')
			]);
		}else{
			return redirect()->route('admin.post.create')
				->withInput()
				->withErrors($validation)
				->with('fail_msg', 'Failed to generate .post file');
		}
	}

}
