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

$router->get('/users','UserController@getUsers');
$router->get('/login', 'UserController@login');
$router->post('/home', 'UserController@test');
$router->get('/', 'UserController@index');
$router->post('users/', 'UserController@create');
$router->get('/users/{id}', 'UserController@search');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@delete');

//UserJob

$router->get('/userjobb','UserJobController@getUsers');
$router->get('/userjob/{id}','UserJobController@show'); // get user by id
$router->get('user/','UserJobController@add');
$router->get('/user/{id}','UserJobController@update');