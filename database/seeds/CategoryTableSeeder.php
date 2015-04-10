<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryModel;

class CategoryTableSeeder extends Seeder {

	public function run(){
		CategoryModel::truncate();
		CategoryModel::create(array(
			'name' => 'Uncategories',
			'slug' => 'uncategories',
			'tag' => 'header'
		));
	}

}
