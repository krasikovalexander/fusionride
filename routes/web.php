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

Route::get('/', ['as' => 'home', 'uses' => 'Front\RequestController@home']);

Route::group(['as' => 'front.'], function () {
	Route::any('/request', ['as' => 'requestForm', 'uses' => 'Front\RequestController@index']);
	Route::get('/request/notavailable', ['as' => 'nocity', 'uses' => 'Front\RequestController@nocity']);
	Route::get('/request/done', ['as' => 'done', 'uses' => 'Front\RequestController@done']);
	Route::get('/request/fail', ['as' => 'fail', 'uses' => 'Front\RequestController@done']);
	Route::get('/request/pdf', ['as' => 'pdf', 'uses' => 'Front\RequestController@pdf']);
	Route::post('/subscribe', ['as' => 'subscribe', 'uses' => 'Front\RequestController@subscribe']);
});

Route::get('login', ['as' => 'loginForm', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::group(['middleware' => ['auth'], 'as' => 'admin.', 'prefix' => 'admin'], function () {
	Route::get('', ['as' => 'dashboard', 'uses' => 'Admin\DashboardController@index']);

	Route::get('types', ['as' => 'types', 'uses' => 'Admin\TypesController@index']);
	Route::any('types/{id}', ['as' => 'types.edit', 'uses' => 'Admin\TypesController@edit'])->where('id', '[0-9]+');
	Route::get('types/{id}/up', ['as' => 'types.up', 'uses' => 'Admin\TypesController@up'])->where('id', '[0-9]+');
	Route::get('types/{id}/down', ['as' => 'types.down', 'uses' => 'Admin\TypesController@down'])->where('id', '[0-9]+');
	Route::any('types/create', ['as' => 'types.create', 'uses' => 'Admin\TypesController@create']);

	Route::get('providers', ['as' => 'providers', 'uses' => 'Admin\ProvidersController@index']);
	Route::get('drafts', ['as' => 'drafts', 'uses' => 'Admin\ProvidersController@drafts']);
	Route::any('providers/{id}', ['as' => 'providers.edit', 'uses' => 'Admin\ProvidersController@edit'])->where('id', '[0-9]+');
	Route::any('providers/create', ['as' => 'providers.create', 'uses' => 'Admin\ProvidersController@create']);
	Route::get('providers/search', ['as' => 'providers.search', 'uses' => 'Admin\ProvidersController@search']);
});
