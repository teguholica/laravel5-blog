<?php namespace App\Http\Controllers;

use App\Models\WebSettingModel;
use Input;

class WebSettingController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		foreach(WebSettingModel::all() as $webSetting){
			$data[$webSetting->attr] = $webSetting->value;
		}
		return view('admin.web_setting.index', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$webSettingModel = WebSettingModel::where('attr', 'web_title')->first();
		$webSettingModel->value = Input::get('web_title');
		$webSettingModel->save();

		$webSettingModel = WebSettingModel::where('attr', 'meta_keyword')->first();
		$webSettingModel->value = Input::get('meta_keyword');
		$webSettingModel->save();

		$webSettingModel = WebSettingModel::where('attr', 'meta_description')->first();
		$webSettingModel->value = Input::get('meta_description');
		$webSettingModel->save();

		return redirect()->route('admin.web_setting.index')->with('success_msg', 'Your setting has been saved');
	}

}
