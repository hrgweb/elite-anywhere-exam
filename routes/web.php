<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// PERSON
Route::get('/person/list', 'PersonController@fetch');
Route::resource('person', 'PersonController');

// ORGANIZATION
Route::get('/organization/list', 'OrganizationController@fetch');
Route::resource('organization', 'OrganizationController');
