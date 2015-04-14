<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('slug')->unique();
			$table->string('title');
			$table->longtext('preview_content');
			$table->longtext('content');
			$table->longtext('lazy_content');
			$table->integer('user_id');
			$table->tinyinteger('is_publish')->default(0);
			$table->tinyinteger('disable_comment')->default(0);
			$table->tinyinteger('show_in_home')->default(0);
			$table->integer('category_id');
			$table->integer('view')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
