<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagModel extends Model {
	
	protected $guarded = array();
	protected $table = 'tags';
	
	public function post(){
		return $this->belongsToMany('App\Models\PostModel', 'post_has_tag', 'tag_id', 'post_id');
	}
	
}
