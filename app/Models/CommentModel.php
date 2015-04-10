<?php
class CommentModel extends Eloquent {
	
	protected $guarded = array();
	protected $table = 'comments';
	
	public function post()
	{
		return $this->hasOne('App\Models\PostModel', 'id', 'post_id');
	}

}
