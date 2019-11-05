<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix'=>'api'], function() use($router){

$router->get('liste_categorie_mission', 'CategorieMissionController@index');
$router->post('add_categorie_mission' , 'CategorieMissionController@store');
$router->put('update_categorie_mission/{id}', 'CategorieMissionController@update');
$router->delete('supprimer_categorie_mission/{id}' ,'CategorieMissionController@destroy');

// route imputtation

$router->get('list_imputation', 'ImputationMissionController@index');
$router->post('add_imputation' , 'ImputationMissionController@store');
$router->put('update_imputation/{id}', 'ImputationMissionController@update');
$router->delete('supprimer_imputation/{id}' ,'ImputationMissionController@destroy');




// route pour mission
$router->get('list_mission', 'MissionController@index');
$router->post('add_mission' , 'MissionController@store');
$router->put('update_mission/{id}', 'MissionController@update');
$router->delete('supprimer_mission/{id}' ,'MissionController@destroy');
});