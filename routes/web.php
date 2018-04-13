<?php

Route::get('/','IndexController@index')->name('index');
Route::get('/about','IndexController@about');
Route::get('/polls/get/{id}','IndexController@getResults');
Route::post('/polls/vote','IndexController@vote');
Route::get('/login','LoginRegisterController@login')->name('login');
Route::get('/logout','LoginRegisterController@logout')->name('logout');
Route::get('/search/{category?}','SearchController@show')->where('category','.*')->name('search');
Route::post('/search/getNumberOfStories','SearchController@getNumberOfStories');
Route::post('/search/getStories','SearchController@getStories');
Route::get('/stories/{id}','StoriesController@show')->name('storiesRead');
Route::get('/stories/galery/{id}', 'StoriesController@galery')->where('id','[\d]+')->name('storiesGalery');
Route::post('/stories/comment','StoriesController@comment')->name('storiesComment');
Route::post('/login','LoginRegisterController@loginUser')->name('loginUser');
Route::get('/register','LoginRegisterController@register')->name('register');
Route::post('/register','LoginRegisterController@registerUser')->name('registerUser');

Route::post('/vote/dislike','LikesDislikesCommentsController@dislike')->middleware('auth')->name('LDCDisLike');
Route::post('/vote/like','LikesDislikesCommentsController@like')->middleware('auth')->name('LDCLike');

Route::group(['prefix' => '/admin', 'middleware' => ['CheckIfAdmin']],function(){
	Route::get('/','AdminController@show')->name('adminShow');
	Route::get('/links','AdminController@links')->name('adminLinks');
	Route::get('/stories','AdminController@storiesShow')->name('adminStories');
	Route::get('/adminCategories','AdminController@categories')->name('adminCategories');
	Route::get('/galery','AdminController@galery')->name('adminGalery');
	Route::get('/users','AdminController@users')->name('adminUsers');
	Route::get('/polls','AdminController@pollsShow')->name('pollsShow');
	Route::get('/comments','AdminController@commentsShow')->name('adminComments');
	Route::get('/paragraphs','AdminController@paragraphsShow')->name('adminParagraphs');
	Route::get('/slider','AdminController@sliderShow')->name('adminSliderShow');
	Route::get('/activity','AdminController@activityShow')->name('adminActivityShow');

	Route::post('/activity/destroyOne','AdminController@activityDestroyOne')->name('adminActivityDestroyOne');
	Route::post('/activity/destroyAll','AdminController@activityDestroyAll')->name('adminActivityDestroyAll');

	Route::post('/slider/add','AdminController@sliderAdd')->name('adminSliderAdd');
	Route::post('/slider/destroy','AdminController@sliderDestroy')->name('adminSliderDestroy');

	Route::post('/paragraphs/multiple','AdminController@paragraphsMultiple')->name('adminParagraphsMultiple');
	Route::post('/paragraphs/destroy','AdminController@paragraphsDestroy')->name('adminParagraphsDestroy');
	Route::post('/paragraphs/edit','AdminController@paragraphsEdit')->name('adminParagraphsEdit');

	Route::post('/stories/edit','AdminController@storiesEdit')->name('adminStoriesEdit');
	Route::post('/stories/destroy','AdminController@storiesDestroy')->name('adminStoriesDestroy');
	Route::post('/stories/add','AdminController@storiesAdd')->name('createNewStory');

	Route::post('/comments/destroy','AdminController@commentsDestroy')->name('adminCommentsDestroy');

	Route::post('/polls/add','AdminController@pollsAdd')->name('adminPollsAdd');
	Route::post('/polls/destroy','AdminController@pollsDestroy')->name('adminPollsDestroy');
	Route::post('/polls/selected','AdminController@pollsSelected')->name('adminPollSelected');
	Route::post('/polls/inactive','AdminController@pollsInactive')->name('adminPollInactive');

	Route::post('/users/edit','AdminController@usersEdit')->name('adminUserEdit');
	Route::post('/users/destroy','AdminController@usersDestroy')->name('adminUserDestroy');

	Route::post('/galery/add','AdminController@galeryAdd')->name('adminGaleryAdd');
	Route::post('/galery/destroy','AdminController@galeryDestroy')->name('adminGaleryDestroy');

	Route::post('/links/add','AdminController@linksAdd')->name('adminLinksAdd');
	Route::post('/links/destroy','AdminController@linksDestroy')->name('adminLinksDestroy');
	Route::post('/links/edit','AdminController@linksEdit')->name('adminLinksEdit');

	Route::post('/adminCategories/add','AdminController@categoriesAdd')->name('adminCategoriesAdd');
	Route::post('/adminCategories/edit','AdminController@categoriesEdit')->name('adminCategoriesEdit');
	Route::post('/adminCategories/destroy','AdminController@categoriesDestroy')->name('adminCategoriesDestroy');
});