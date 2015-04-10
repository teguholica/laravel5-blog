<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserModel;

class UserTableSeeder extends Seeder {

	public function run(){
		UserModel::truncate();
		UserModel::create(array(
			'display_name' => 'Teguh Arifianto',
			'name' => 'teguholica',
			'email' => 'teguholica@gmail.com',
           	'password' => Hash::make('1234')
		));
	}

}
