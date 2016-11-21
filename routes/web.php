<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::resource('users', 'UserController');
Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard');
Route::get('/profile/{username}', 'UserController@show')->name('user.profile');

Route::group(['prefix' => 'auth'], function () {
    Route::get('/register','Auth\AuthController@register')->name('auth.register');
    Route::get('/login','Auth\AuthController@login')->name('auth.login');
    Route::get('/dologin','Auth\AuthController@dologin')->name('auth.dologin');
    Route::get('/github','Auth\AuthController@redirectToProvider')->name('auth.github');
    Route::get('/github/callback', 'Auth\AuthController@handleProviderCallback');
});

Route::group(['prefix' => 'product_backlogs'], function () {
    Route::get('/list/{mode?}', 'ProductBacklogController@index')->name('product_backlogs.index');
    Route::get('/show/{slug}', 'ProductBacklogController@show')->name('product_backlogs.show');
    Route::get('/create', 'ProductBacklogController@create')->name('product_backlogs.create');
    Route::post('/store', 'ProductBacklogController@store')->name('product_backlogs.store');
    Route::get('/edit/{slug}', 'ProductBacklogController@edit')->name('product_backlogs.edit');
    Route::post('/update/{slug}', 'ProductBacklogController@update')->name('product_backlogs.update');
});

Route::group(['prefix' => 'sprints', 'middleware' => ['sprint.expired', 'global.activities']], function () {
    Route::get('/list/{mode?}/{slug_product_backlog?}', 'SprintController@index')->name('sprints.index');
    Route::get('/show/{slug}', 'SprintController@show')->name('sprints.show');
    Route::get('/create/{slug_product_backlog?}', 'SprintController@create')->name('sprints.create');
    Route::post('/store', 'SprintController@store')->name('sprints.store');
    Route::get('/edit/{slug}', 'SprintController@edit')->name('sprints.edit');
    Route::post('/update/{slug}', 'SprintController@update')->name('sprints.update');
});

Route::group(['prefix' => 'user-stories'], function () {
    Route::get('/list/{mode?}/{slug_product_backlog?}', 'SprintController@index')->name('user_stories.index');
    Route::get('/show/{slug}', 'UserStoryController@show')->name('user_stories.show');
    Route::get('/create/{slug_product_backlog?}', 'UserStoryController@create')->name('user_stories.create');
    Route::post('/store', 'UserStoryController@store')->name('user_stories.store');
    Route::get('/edit/{slug}', 'UserStoryController@edit')->name('user_stories.edit');
    Route::post('/update/{slug}', 'UserStoryController@update')->name('user_stories.update');
});

Route::group(['prefix' => 'issues'], function () {
    Route::get('/sprint-planning/{slug}', 'IssueController@index')->name('issues.index');
    Route::get('/show/{slug}', 'IssueController@show')->name('issues.show');
    Route::get('/create/{slug_sprint?}/{slug_user_story?}', 'IssueController@create')->name('issues.create');
    Route::post('/store', 'IssueController@store')->name('issues.store');
    Route::get('/edit/{slug}', 'IssueController@edit')->name('issues.edit');
    Route::post('/update/{slug}', 'IssueController@update')->name('issues.update');
    Route::get('/destroy/{slug}', 'IssueController@destroy')->name('issues.destroy');
    Route::get('/status-update/{slug}/{status}', 'IssueController@statusUpdate')->name('issues.status.update');
});

Route::group(['prefix' => 'user-issue'], function () {
    Route::get('/list/{username}/{slug_type?}/{mode?}', 'UserIssueController@index')->name('user_issue.index');
    Route::post('/update/{slug}', 'UserIssueController@update')->name('user_issue.update');
});

Route::group(['prefix' => 'issue-types'], function () {
    Route::get('/sprint/{slug_sprint}/{slug_type?}', 'IssueTypeController@index')->name('issue_types.index');
});

Route::group(['prefix' => 'commits'], function () {
    Route::get('/show/{sha}', 'CommitController@show')->name('commits.show');
});

Route::group(['prefix' => 'notes'], function () {
    Route::get('/--------', 'NoteController@store')->name('notes.show');
    Route::post('/store', 'NoteController@store')->name('notes.store');
    Route::get('/update/{slug}', 'NoteController@update')->name('notes.update');
    Route::get('/destroy/{id}', 'NoteController@destroy')->name('notes.destroy');
});

Route::group(['prefix' => 'comment'], function () {
    Route::get('/--------', 'CommentController@store')->name('comments.show');
    Route::post('/store', 'CommentController@store')->name('comments.store');
    Route::get('/destroy/{id}', 'CommentController@destroy')->name('comments.destroy');
});

Route::group(['prefix' => 'label'], function () {
    Route::get('/{model}/{slug_label?}', 'LabelController@index')->name('labels.index');
    Route::post('/store', 'LabelController@store')->name('labels.store');
});

Route::group(['prefix' => 'favorite'], function () {
    Route::get('/store/{type}/{id}', ['uses' => 'FavoriteController@store','as'=>'favorite.store']);
    Route::get('/destroy/{type}/{id}', ['uses' => 'FavoriteController@destroy','as'=>'favorite.destroy']);
});

Route::group(['prefix' => 'team'], function () {
    Route::get('/list', ['uses' => 'TeamController@index','as'=>'team.index']);
});

Auth::routes();