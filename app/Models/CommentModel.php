<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model {
	
	protected $guarded = array();
	protected $table = 'comments';
	
	public function post()
	{
		return $this->hasOne('App\Models\PostModel', 'id', 'post_id');
	}

}
