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

Route::get('/{id}/apply', 'TournamentController@getApplication');
Route::post('/{id}/sendApplication', 'TournamentController@postApplication');
Route::post('/{id}/removeApplication', 'TournamentController@removeApplication');

Route::get('/newTournament', 'TournamentController@newTournament');
Route::post('/createTournament', 'TournamentController@createTournament');
Route::get('/{tournamentId}/deleteTournament', 'TournamentController@deleteTournament');

Route::get('/{tournamentId}/run/q/conf/{currentSquadId}', 'TournamentController@runQualificationConfirm');
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

Route::get('/account', 'UserController@showAccount');
Route::get('/account/edit', 'UserController@editAccount');
Route::post('/account/save', 'UserController@saveAccount');
Route::get('/getStatistic', 'UserController@getStatistic');
Route::get('/players', 'UserController@getPlayers');
// Route::get('/getContact/{id}', 'UserController@getContact');
//Route::post('/saveTempImage', 'UserController@saveTempImage');

Route::get('/setGameResult', 'GameController@setResult');
Route::get('/changeGameResult', 'GameController@changeResult');
Route::get('/sumBlock', 'GameController@sumBlock');
Route::get('/updateBonus', 'GameController@updateBonus');
