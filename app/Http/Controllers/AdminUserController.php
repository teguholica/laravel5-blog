<?php  namespace App\Http\Controllers;

use App\Models\UserModel;
use Validator;
use Input;
use Hash;
use Auth;

class AdminUserController extends Controller {

	public function indexView(){
		$data['users'] = UserModel::all();
		return view('admin.user.index', $data);
	}

	public function addView(){
		return view('admin.user.add');
	}

	public function addAction(){
		$rules = array(
			'display_name' => 'required',
			'username' => 'required', 
			'password' => 'required',
			'retypepassword' => 'required|same:password'
		);
		$validation = Validator::make(Input::all(), $rules);
		if ($validation->passes()){
			$user = new UserModel();
			$user->display_name = Input::get('display_name');
			$user->name = Input::get('username');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();
			return redirect()->route('admin.user.index.view');
		}

		return redirect()->route('admin.user.add.view')
			->withInput()
			->withErrors($validation)
			->with('message_fail', 'There were validation errors.');
	}

	public function editView($userId){
		$user = UserModel::find($userId);
		return view('admin.user.edit', compact('user'));
	}

	public function editAction($userId){
		$rules = array(
			'display_name' => 'required',
		);
		$validation = Validator::make(Input::all(), $rules);
		if ($validation->passes()){
			$user = UserModel::find($userId);
			$user->display_name = Input::get('display_name');
			$user->save();
			return redirect()->route('admin.user.index.view');
		}

		return redirect()->route('admin.user.edit.view', $userId)
			->withInput()
			->withErrors($validation)
			->with('message_fail', 'There were validation errors.');
	}

	public function deleteAction($userId){
		UserModel::find($userId)->delete();
		return redirect()->route('admin.user.index.view');
	}
	
	public function changeCurrentPasswordView(){
		return view('admin.user.changeCurrentPassword');
	}
	
	public function changeCurrentPasswordAction(){
		$rules = array(
			'password' => 'required',
			'retypepassword' => 'required|same:password'
		);
		$validation = Validator::make(Input::all(), $rules);
		if ($validation->passes()){
			$user = UserModel::find(Auth::user()->id);
			$user->password = Hash::make(Input::get('password'));
			$user->save();
			return redirect()->route('admin.user.index.view')
				->with('message', 'Password has been changed');
		}

		return redirect()->route('admin.user.changeCurrentPassword.view')
			->withInput()
			->withErrors($validation)
			->with('message_fail', 'There were validation errors.');
	}

}
