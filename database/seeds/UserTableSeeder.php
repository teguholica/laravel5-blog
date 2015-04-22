<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserModel;

class UserTableSeeder extends Seeder {

	public function run(){
		UserModel::truncate();
		UserModel::create(array(
			'display_name' => 'Admin',
			'name' => 'admin',
			'email' => 'admin@admin.com',
           	'password' => Hash::make('admin')
		));
	}

}
