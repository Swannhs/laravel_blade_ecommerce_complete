<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::name('blog.')->prefix('blog')->group(function(){
	Route::get('/', 'BlogController@index')->name('index') ;
	Route::get('post/{slug}','BlogController@singlePage')->name('single.page');
	//category wise post
	Route::get('/category/posts/{slug}','BlogController@catgoryPost')->name('category.posts');
	Route::get('/search','BlogController@search')->name('posts.search');

	Route::middleware('admin')->group(function(){
		Route::resource('categories','BlogCategoryController',['name'=>'categories'])->middleware(['permission']);
		Route::resource('tags','BlogTagController',['name'=>'tags'])->middleware(['permission']);
		Route::get('/tags/list/get-data','BlogTagController@getData')->name('tag.get-data');
		Route::post('/post/approve','BlogPostController@approval')->name('post.approval')->middleware('prohibited_demo_mode');
		Route::post('/post/status/update','BlogPostController@statusUpdate')->name('post.status.update')->middleware('prohibited_demo_mode');
		Route::resource('posts','BlogPostController',['name'=>'posts'])->middleware(['permission']);
		Route::get('/posts/list/get-data','BlogPostController@getData')->name('post.get-data');
		//delete post image
		Route::post('/post-img/delete','BlogPostController@deletePostImage')->name('post.image.delete')->middleware('prohibited_demo_mode');
	});

	Route::middleware('auth')->group(function(){
		Route::post('/replay','BlogController@replay')->name('replay')->middleware('prohibited_demo_mode');
		Route::post('/like','BlogController@like')->name('post.like')->middleware('prohibited_demo_mode');

		//comments
		Route::post('/comment/{post_id}','BlogController@commentStore')->name('comment.store')->middleware('prohibited_demo_mode');
	});
});
