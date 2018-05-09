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
use Illuminate\Support\Facades\Auth;

Auth::routes();

// Tournament Routes
Route::get('/', 'TournamentController@index');
Route::get('/{tournamentId}/details', 'TournamentController@details');
Route::get('/{tournamentId}/players', 'TournamentController@players');
Route::get('/{tournamentId}/results', 'TournamentController@results');

// Возможно, 'new' и 'create' должны быть одним методом?
Route::get('/newTournament', 'TournamentController@newTournament')->middleware('auth');
Route::post('/createTournament', 'TournamentController@createTournament')->middleware('auth');
Route::get('/{tournamentId}/deleteTournament', 'TournamentController@deleteTournament')->middleware('auth');
Route::get('/{tournamentId}/editTournament', 'TournamentController@editTournament')->middleware('auth');
Route::post('/{tournamentId}/saveTournament', 'TournamentController@saveTournament')->middleware('auth');

// Application Routes
Route::get('/{tournamentId}/apply', 'ApplicationController@index')->middleware('auth');
Route::post('/{tournamentId}/sendApplication', 'ApplicationController@post')->middleware('auth');
Route::post('/{tournamentId}/removeApplication/{playerId}', 'ApplicationController@remove')->middleware('auth');

// Game Running Routes
// * Qualification
Route::get('/{tournamentId}/run/q/conf/{currentSquadId}', 'QualificationController@confirm')->middleware('auth');
Route::post('/{tournamentId}/run/q/draw/{currentSquadId}', 'QualificationController@draw')->middleware('auth');
Route::post('/{tournamentId}/run/q/game/{currentSquadId}', 'QualificationController@game')->middleware('auth');
Route::post('/{tournamentId}/run/q/rest/{currentSquadId}', 'QualificationController@squadResults')->middleware('auth');
Route::get('/{tournamentId}/run/q/rest', 'QualificationController@results')->middleware('auth');

// * Round Robin
Route::get('/{tournamentId}/run/rr/conf/', 'RoundRobinController@confirm');
Route::post('/{tournamentId}/run/rr/draw', 'RoundRobinController@draw');
Route::post('/{tournamentId}/run/rr/game', 'RoundRobinController@game');
Route::get('/{tournamentId}/run/rr/rest', 'RoundRobinController@results');

// Squads Routes
Route::get('/getSquadFilling/{id}', 'SquadController@getSquadFilling');
Route::get('/addSquadForm', 'SquadController@addSquadForm');

// Accout Routes
// Route::get('/account', 'UserController@showAccount')->middleware('auth');
Route::get('/{playerId}/account', 'UserController@showAccount')->middleware('auth');
Route::get('/account/edit', 'UserController@editAccount')->middleware('auth');
Route::post('/account/save', 'UserController@saveAccount')->middleware('auth');
Route::get('/{playerId}/getStatistic', 'UserController@getStatistic')->middleware('auth');
Route::get('/players', 'UserController@getPlayers')->middleware('auth');
Route::get('/{tournamentId}/{squadId}/getPlayers', 'UserController@getApplicationPlayers')->middleware('auth');
Route::get('/account/{playerId}/toggleAdmin', 'UserController@toggleAdmin')->middleware('auth');

// Game Routes
Route::get('/setGameResult', 'GameController@setResult');
Route::get('/changeGameResult', 'GameController@changeResult');
Route::post('/changeGameById', 'GameController@changeById');
Route::get('/sumBlock', 'GameController@sumBlock');
Route::get('/updateBonus', 'GameController@updateBonus');
