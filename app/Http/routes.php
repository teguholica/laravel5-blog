<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['namespace' => 'Frontend'], function(){
	Route::get('/', ['as' => 'blog.index', 'uses' => 'HomeController@index']);
	Route::get('show/{slug}.html', ['as' => 'blog.show', 'uses' => 'PostController@index']);
	Route::post('comment/{postId}', ['as' => 'blog.store_comment', 'uses' => 'PostController@storeComment']);
	Route::get('tag/{tagSlug}.html', ['as' => 'blog.tag', 'uses' => 'TagController@index']);
	Route::get('category/{categorySlug}.html', ['as' => 'blog.category', 'uses' => 'CategoryController@index']);
	Route::get('search', ['as' => 'blog.search', 'uses' => 'SearchController@index']);
});

Route::post('gcm_service/register', array('as' => 'gcm_service.register', 'uses' => 'GCMServiceController@register'));
Route::post('gcm_service/unregister', array('as' => 'gcm_service.unregister', 'uses' => 'GCMServiceController@unregister'));
Route::get('gcm_service/send_msg', array('as' => 'gcm_service.send_msg', 'uses' => 'GCMServiceController@sendMsg'));
Route::get('admin', array('middleware' => 'auth', 'as' => 'admin.dashboard.index', 'uses' => 'DashboardController@index'));
Route::get('admin/user', array('middleware' => 'auth', 'as' => 'admin.user.index.view', 'uses' => 'AdminUserController@indexView'));
Route::get('admin/user/add', array('middleware' => 'auth', 'as' => 'admin.user.add.view', 'uses' => 'AdminUserController@addView'));
Route::post('admin/user/add', array('middleware' => 'auth', 'as' => 'admin.user.add.action', 'uses' => 'AdminUserController@addAction'));
Route::get('admin/user/delete/{userId}', array('middleware' => 'auth', 'as' => 'admin.user.delete.action', 'uses' => 'AdminUserController@deleteAction'));
Route::get('admin/user/edit/{userId}', array('middleware' => 'auth', 'as' => 'admin.user.edit.view', 'uses' => 'AdminUserController@editView'));
Route::post('admin/user/edit/{userId}', array('middleware' => 'auth', 'as' => 'admin.user.edit.action', 'uses' => 'AdminUserController@editAction'));
Route::get('admin/user/change_current_password', array('middleware' => 'auth', 'as' => 'admin.user.changeCurrentPassword.view', 'uses' => 'AdminUserController@changeCurrentPasswordView'));
Route::post('admin/user/change_current_password', array('middleware' => 'auth', 'as' => 'admin.user.changeCurrentPassword.action', 'uses' => 'AdminUserController@changeCurrentPasswordAction'));
Route::get('admin/post', array('middleware' => 'auth', 'as' => 'admin.post.index', 'uses' => 'PostController@index'));
Route::get('admin/post/add', array('middleware' => 'auth', 'as' => 'admin.post.create', 'uses' => 'PostController@create'));
Route::post('admin/post/add', array('middleware' => 'auth', 'as' => 'admin.post.store', 'uses' => 'PostController@store'));
Route::get('admin/post/delete/{postId}', array('middleware' => 'auth', 'as' => 'admin.post.destroy', 'uses' => 'PostController@destroy'));
Route::get('admin/post/edit/{postId}', array('middleware' => 'auth', 'as' => 'admin.post.edit', 'uses' => 'PostController@edit'));
Route::post('admin/post/edit/{postId}', array('middleware' => 'auth', 'as' => 'admin.post.update', 'uses' => 'PostController@update'));
Route::get('admin/post/tag.json', array('middleware' => 'auth', 'as' => 'admin.post.tag.json', 'uses' => 'AdminPostController@postTagJson'));
Route::get('admin/tag', array('middleware' => 'auth', 'as' => 'admin.tag.index', 'uses' => 'TagController@index'));
Route::get('admin/tag/create', array('middleware' => 'auth', 'as' => 'admin.tag.create', 'uses' => 'TagController@create'));
Route::post('admin/tag/create', array('middleware' => 'auth', 'as' => 'admin.tag.store', 'uses' => 'TagController@store'));
Route::get('admin/tag/destroy/{tagId}', array('middleware' => 'auth', 'as' => 'admin.tag.destroy', 'uses' => 'TagController@destroy'));
Route::get('admin/tag/edit/{tagId}', array('middleware' => 'auth', 'as' => 'admin.tag.edit', 'uses' => 'TagController@edit'));
Route::post('admin/tag/edit/{tagId}', array('middleware' => 'auth', 'as' => 'admin.tag.update', 'uses' => 'TagController@update'));
Route::get('admin/category', array('middleware' => 'auth', 'as' => 'admin.category.index', 'uses' => 'CategoryController@index'));
Route::get('admin/category/create', array('middleware' => 'auth', 'as' => 'admin.category.create', 'uses' => 'CategoryController@create'));
Route::post('admin/category/create', array('middleware' => 'auth', 'as' => 'admin.category.store', 'uses' => 'CategoryController@store'));
Route::get('admin/category/destroy/{categoryId}', array('middleware' => 'auth', 'as' => 'admin.category.destroy', 'uses' => 'CategoryController@destroy'));
Route::get('admin/category/edit/{categoryId}', array('middleware' => 'auth', 'as' => 'admin.category.edit', 'uses' => 'CategoryController@edit'));
Route::post('admin/category/edit/{categoryId}', array('middleware' => 'auth', 'as' => 'admin.category.update', 'uses' => 'CategoryController@update'));
Route::get('admin/gcm_device', array('middleware' => 'auth', 'as' => 'admin.gcm_device.index', 'uses' => 'GCMDeviceController@index'));
Route::get('admin/gcm_device/destroy/{gcmDeviceId}', array('middleware' => 'auth', 'as' => 'admin.gcm_device.destroy', 'uses' => 'GCMDeviceController@destroy'));
Route::get('admin/web_setting', array('middleware' => 'auth', 'as' => 'admin.web_setting.index', 'uses' => 'WebSettingController@index'));
Route::post('admin/web_setting', array('middleware' => 'auth', 'as' => 'admin.web_setting.update', 'uses' => 'WebSettingController@update'));
Route::get('sitemap.xml', function(){
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"sitemap.xml\""); 

    $sitemap = App::make("sitemap");
    $sitemap->setCache('laravel.sitemap', 3600);
    if (!$sitemap->isCached()){
        $sitemap->add(URL::to('/'), date('Y-m-dTH:i:s+00:00'), '0.5', 'weekly');
	    $posts = App\Models\PostModel::orderBy('updated_at', 'desc')->get();
	    foreach ($posts as $post){
	    	$sitemap->add(route('blog.show', $post->slug), date('Y-m-dTH:i:s+00:00', strtotime($post->updated_at)), '0.5', 'weekly');
	    }
	    $tags = App\Models\TagModel::all();
		foreach($tags as $tag){
			$sitemap->add(route('blog.tag', $tag->slug), date('Y-m-dTH:i:s+00:00'), '0.5', 'weekly');
		}
		$categories = App\Models\CategoryModel::all();
		foreach($categories as $category){
			$sitemap->add(route('blog.category', $category->slug), date('Y-m-dTH:i:s+00:00'), '0.5', 'weekly');
		}
    }
    return $sitemap->render('xml');
});