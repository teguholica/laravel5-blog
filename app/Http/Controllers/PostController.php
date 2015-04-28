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
			}else{
				//Save preview image if custom content enable
				$previewImage = Input::file('preview_image');
				if ($previewImage->isValid())
				{
					$previewImageFilename = 'preview_'.date('YmdHis').'.'.$previewImage->getClientOriginalExtension();
				    $previewImage->move(public_path('images/preview'), $previewImageFilename);
				    $input['preview_image'] = $previewImageFilename;
				}
			}
			
			$html = HtmlDomParser::str_get_html(Input::get('content'));
			$imageList = [];
			foreach($html->find('img') as $key => $element){
				$imageEncode = preg_replace('#^data:image/[^;]+;base64,#', '', $element->src);
				$imageDecode = base64_decode($imageEncode);
				
				$filename = date('YmdHis').$key;
				$file = Image::fromBase64($imageEncode, public_path('images/generate/'.$filename));
				$imageSize = getimagesizefromstring($imageDecode);
				
				$element->class = 'lazy';
				$element->{"data-src"} = asset('images/generate/'.$file);
				$element->src = route('image_placeholder.load', array('h' => $imageSize[1], 'w' => $imageSize[0], 't' => 'Loading...'));

				//Save image to imageList array
				$imageList[] = $filename;
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
			$post = PostModel::find($id);

			$input = Input::except('enable_preview_content', 'tags');
			$input['user_id'] = Auth::user()->id;
			
			if(!Input::has('enable_preview_content')){
				$input['preview_content'] = "";
			}else{
				//Save preview image if custom content enable
				if(!empty($post->preview_image) && file_exists(public_path('images/preview/'.$post->preview_image))){
					unlink(public_path('images/preview/'.$post->preview_image));
				}
				$previewImage = Input::file('preview_image');
				if ($previewImage->isValid())
				{
					$previewImageFilename = 'preview_'.date('YmdHis').'.'.$previewImage->getClientOriginalExtension();
				    $previewImage->move(public_path('images/preview'), $previewImageFilename);
				    $input['preview_image'] = $previewImageFilename;
				}
			}

			//Destroy old image for this content
			$imageList = json_decode($post->images);
			if(!empty($imageList)){
				foreach($imageList as $image){
					$imageFile = public_path('images/generate/'.$image);
					if(file_exists($imageFile)){
						unlink($imageFile);
					}
				}
			}
			
			$html = HtmlDomParser::str_get_html(Input::get('content'));
			$imageList = [];
			foreach($html->find('img') as $key => $element){
				//Get real base64 format
				$imageEncode = preg_replace('#^data:image/[^;]+;base64,#', '', $element->src);

				//Get height, width, and extension
				$imageInfo = Image::getImageInfoFromBase64($imageEncode);

				//Generate image filename and save to images folder
				$filename = date('YmdHis').'_'.$key.$imageInfo->ext;
				$file = Image::fromBase64($imageEncode, public_path('images/generate/'.$filename));
				
				//Parse image css to get height and width
				$imageStyle = array();
				preg_match_all("/([\w-]+)\s*:\s*([^;]+)\s*;?/", $element->style, $matches, PREG_SET_ORDER);
				foreach ($matches as $match) {
					$imageStyle[$match[1]] = $match[2];
				}

				//Calculate new image size
				if(strpos($imageStyle['width'], '%')){
					$imageWidth = $imageStyle['width']/100*$imageInfo->width;
					$imageHeight = ($imageWidth*$imageInfo->height)/$imageInfo->width;
				}else{
					$imageWidth = $imageInfo->width;
					$imageHeight = $imageInfo->height;
				}

				//Modify content img to use lazy imageloader
				$element->class = $element->class.' lazy';
				$element->width = $imageWidth;
				$element->height = $imageHeight;
				$element->href = asset('images/generate/'.$file);
				$element->{"data-original"} = asset('images/generate/'.$file);
				$element->src = null;
				$element->style = null;

				//Save image to imageList array
				$imageList[] = $filename;
			}
			$html->save();
			$input["lazy_content"] = $html;

			//Store imageList to input variable with JSON format
			$input['images'] = json_encode($imageList);
			
			//Check if is_publish flag doesn't exist or unchecked, set to "0" or unpublish
			if(!Input::has("is_publish")){
				$input["is_publish"] = "0";
			}
			
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

}
