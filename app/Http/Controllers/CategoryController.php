<?php namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Validator;
use Input;

class CategoryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['categories'] = CategoryModel::all();
		return view('admin.category.index', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.category.create');
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
			CategoryModel::create($input);
			return redirect()->route('admin.category.index')
				-> with('success_msg', 'Succesfully created new category');
		}else{
			return redirect()->route('admin.category.create')
				-> withErrors($validation)
				-> withInput()
				-> with('fail_msg', 'Failed to create new category');
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
		$data['category'] = CategoryModel::find($id);
		return view('admin.category.edit', $data);
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
		$validation = Validator::make(Input::all(), $rules);
		if ($validation -> passes()) {
			CategoryModel::find($id) -> update(Input::all());
			return redirect()->route('admin.category.index')
				-> with('success_msg', 'Succesfully edited category');
		}else{
			return redirect()->route('admin.category.edit', $id)
				-> withErrors($validation)
				-> withInput()
				-> with('fail_msg', 'Failed to edit category');
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
		CategoryModel::find($id)->delete();
		return redirect()->route('admin.category.index')
			-> with('success_msg', 'Succesfully deleted category');
	}


}
