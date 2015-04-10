<?php namespace App\Http\Controllers;

use App\Models\TagModel;
use Validator;
use Input;

class TagController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['tags'] = TagModel::all();
		return view('admin.tag.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.tag.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array('name' => 'required');
		$input = Input::all();
		$validation = Validator::make($input, $rules);
		if ($validation -> passes()) {
			TagModel::create($input);
			return redirect()->route('admin.tag.index')
				-> with('success_msg', 'Successfully to create new tag');
		}else{
			return redirect()->route('admin.post_category.add')
				-> withErrors($validation)
				-> withInput()
				-> with('fail_msg', 'Failed to create new tag');
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
		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data['tag'] = TagModel::find($id);
		return view('admin.tag.edit', $data);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array('name' => 'required');
		$input = Input::all();
		$validation = Validator::make($input, $rules);
		if ($validation -> passes()) {
			TagModel::find($id)->update($input);
			return redirect()->route('admin.tag.index')
				-> with('success_msg', 'Successfully to edit tag');
		}else{
			return redirect()->route('admin.post_category.add')
				-> withErrors($validation)
				-> withInput()
				-> with('fail_msg', 'Failed to edit tag');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		TagModel::find($id)->delete();
		return redirect()->route('admin.tag.index')
			-> with('success_msg', 'Successfully deleted tag');
	}


}
