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

Route::get('/', 'TournamentController@index');
Route::get('/{tournamentId}/details', 'TournamentController@details');
Route::get('/{id}/players', 'TournamentController@getTournamentPlayers');
Route::get('/{tournamentId}/results', 'TournamentController@getResults');

Route::get('/{id}/apply', 'TournamentController@getApplication')->middleware('auth');
Route::post('/{id}/sendApplication', 'TournamentController@postApplication')->middleware('auth');
Route::post('/{id}/removeApplication/{playerId}', 'TournamentController@removeApplication')->middleware('auth');

Route::get('/newTournament', 'TournamentController@newTournament')->middleware('auth');
Route::post('/createTournament', 'TournamentController@createTournament');
Route::get('/{tournamentId}/deleteTournament', 'TournamentController@deleteTournament')->middleware('auth');
Route::get('/{tournamentId}/editTournament', 'TournamentController@editTournament')->middleware('auth');
Route::post('/{tournamentId}/saveTournament', 'TournamentController@saveTournament');

Route::get('/{tournamentId}/run/q/conf/{currentSquadId}', 'TournamentController@runQualificationConfirm')->middleware('auth');
Route::get('/{tournamentId}/run/q/draw/{currentSquadId}', 'TournamentController@runQualificationDraw');
Route::get('/{tournamentId}/run/q/game/{currentSquadId}', 'TournamentController@runQualificationGame');
Route::post('/{tournamentId}/run/q/rest/{currentSquadId}', 'TournamentController@qualificationSquadResults');
Route::get('/{tournamentId}/run/q/rest', 'TournamentController@qualificationResults');

Route::get('/{tournamentId}/run/rr/conf/', 'TournamentController@runRoundRobinConfirm');
Route::get('/{tournamentId}/run/rr/draw', 'TournamentController@runRoundRobinDraw');
Route::get('/{tournamentId}/run/rr/game', 'TournamentController@runRoundRobinGame');
Route::get('/{tournamentId}/run/rr/rest', 'TournamentController@roundRobinResults');

Route::get('/getSquadFilling/{id}', 'SquadController@getSquadFilling');
Route::get('/addSquadForm', 'SquadController@addSquadForm');

Route::get('/account', 'UserController@showAccount')->middleware('auth');
Route::get('/{playerId}/account', 'UserController@showAccount')->middleware('auth');
Route::get('/account/edit', 'UserController@editAccount')->middleware('auth');
Route::post('/account/save', 'UserController@saveAccount')->middleware('auth');
Route::get('/{playerId}/getStatistic', 'UserController@getStatistic')->middleware('auth');
Route::get('/players', 'UserController@getPlayers')->middleware('auth');
Route::get('/{tournamentId}/{squadId}/getPlayers', 'UserController@getApplicationPlayers')->middleware('auth');
Route::get('/account/{playerId}/toggleAdmin', 'UserController@toggleAdmin')->middleware('auth');

Route::get('/setGameResult', 'GameController@setResult');
Route::get('/changeGameResult', 'GameController@changeResult');
Route::get('/sumBlock', 'GameController@sumBlock');
Route::get('/updateBonus', 'GameController@updateBonus');
