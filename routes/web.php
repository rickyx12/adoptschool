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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', 'Home@index');
Route::get('/projects', 'Home@projects');
Route::post('/projects/filtered', 'Home@showFilteredProjects');

Route::prefix('/stakeholders')->group(function() {
	Route::get('/registration', 'Users@stakeholder');
	Route::post('/register', 'Users@stakeholderRegister');
	Route::get('/sector', 'Users@getSector');
	Route::get('/sector/{sectorId}/subsector', 'Users@getSubSector');
	Route::post('/authenticate', 'Users@stakeholdersAuth');
});


Route::prefix('/school')->group(function() {
	Route::get('/registration', 'Users@school');
	Route::post('/register', 'Users@schoolRegister');
	Route::post('/authenticate', 'Users@schoolsAuth');
});

Route::get('/login', 'Users@login');
Route::get('/category', 'Home@getCategory');
Route::get('region/{regionId}/divisions', 'Users@getDivision');


Route::prefix('/account')->group(function() {
	
	Route::get('/stakeholders', 'Stakeholders@index');
	Route::prefix('/stakeholders')->group(function() {
		
		Route::get('/projects', 'Stakeholders@projects');
		Route::prefix('/projects')->group(function() {
			Route::post('/filtered', 'Stakeholders@showFilteredProjects');
			Route::post('/comments/add', 'Stakeholders@addComment');
			Route::get('{projectId}/comments', 'Stakeholders@getComments');
			Route::post('/stakeholders/add', 'Stakeholders@addStakeholder');
		});


		Route::get('/contributions', 'Stakeholders@getProjectContributions');
		Route::prefix('/contributions')->group(function() {
			Route::post('/filtered', 'Stakeholders@getFilteredProjectContributions');
		});

		Route::get('/logout', 'Stakeholders@logout');
	});


	Route::get('/schools', 'Schools@index');
	Route::prefix('/schools')->group(function() {
		Route::get('/logout', 'Schools@logout');
		Route::get('/projects', 'Schools@projects');
		Route::post('/projects/add', 'Schools@newProject');

		Route::prefix('/projects')->group(function() {
			Route::post('/updates/add', 'Schools@addProjectUpdate');
			Route::post('/comments/add', 'Schools@addComment');
			Route::get('{projectId}/comments', 'Schools@getComments');
			Route::get('{projectId}/comments/{commentId}/{userType}', 'Schools@getSingleComment');
			Route::post('/filtered', 'Schools@filteredProjects');
			Route::post('/publish', 'Schools@publishControl');				
		});

		Route::get('/stakeholders', 'Schools@stakeholders');

	});
});