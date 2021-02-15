<?php

use App\Models\Organization;
use App\Models\User;
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
    // return User::find(4)->organizations()->get();
    // return Organization::find(2)->persons()->get();

    return view('welcome');
});

// PERSON
Route::get('/person/list', 'PersonController@fetch');
Route::get('/person/{id}/organization/list', 'PersonController@organizations');
Route::resource('person', 'PersonController');

// ORGANIZATION
Route::get('/organization/list', 'OrganizationController@fetch');
Route::resource('organization', 'OrganizationController');
