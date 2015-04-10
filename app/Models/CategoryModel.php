<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model {
	
	protected $guarded = array();
	protected $table = 'categories';
	
	public function post(){
		return $this->hasMany('App\Models\PostModel', 'category_id', 'id');
	}
	
}
