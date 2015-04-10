<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model {
	
	protected $guarded = array();
	protected $table = 'posts';
	
	public function user(){
		return $this->hasOne('App\Models\UserModel', 'id', 'user_id');
	}
	
	public function category(){
		return $this->hasOne('App\Models\CategoryModel', 'id', 'category_id');
	}

	public function tag(){
		return $this->belongsToMany('App\Models\TagModel', 'post_has_tag', 'post_id', 'tag_id');
	}

	public function comment()
	{
		return $this->hasMany('App\Models\CommentModel', 'post_id', 'id');
	}
	
}
