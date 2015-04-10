<?php namespace App\Http\Controllers;

use App\Models\GCMDeviceModel;

class GCMDeviceController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['GCMDevices'] = GCMDeviceModel::paginate(15);
		return view('admin.gcm_device.index', $data);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		GCMDeviceModel::find($id)->delete();
		return Redirect::route('admin.gcm_device.index')
			->with('success_msg', 'Succesfully deleted device');
	}


}
