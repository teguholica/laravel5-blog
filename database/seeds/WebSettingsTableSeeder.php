<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\WebSettingModel;

class WebSettingsTableSeeder extends Seeder {

	public function run(){
		
		WebSettingModel::truncate();

		WebSettingModel::create(array(
			'attr' 	=> 'web_title',
			'value'	=> 'Web Title'
		));

		WebSettingModel::create(array(
			'attr' 	=> 'meta_keyword',
			'value'	=> ''
		));

		WebSettingModel::create(array(
			'attr' 	=> 'meta_description',
			'value'	=> ''
		));

	}

}
