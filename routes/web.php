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


// ûpload file
$router->post('add_upload', 'UploadController@upload');

/**
 *
 */


// route pour mission
$router->get('list_mission', 'MissionController@index');
$router->post('add_mission' , 'MissionController@store');
$router->put('update_mission/{id}', 'MissionController@update');
$router->delete('supprimer_mission/{id}' ,'MissionController@destroy');


// norme de mission
$router->get('liste_norme_mission', 'NormeMissionController@index');
$router->post('add_norme_mission' , 'NormeMissionController@store');
$router->put('update_norme_mission/{id}', 'NormeMissionController@update');
$router->delete('supprimer_norme_mission/{id}' ,'NormeMissionController@destroy');


// historique mision

 $router->get('liste_historique_mission', 'HistoriqueMissionController@index');

$router->post('add_historique_mission' , 'HistoriqueMissionController@store');

 $router->put('update_historique_mission/{id}', 'HistoriqueMissionController@update');

 $router->delete('supprimer_historique_mission/{id}' ,'HistoriqueMissionController@destroy');



/**
 *
 */


});