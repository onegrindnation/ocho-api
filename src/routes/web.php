<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// This pile of shit matches only base64 encoded guids. I think.
define('BASE64_GUID_PATTERN', "(?=.{24}\$)(?:[A-Za-z0-9+\\/]{4})*(?:[A-Za-z0-9+\\/]{4}|[A-Za-z0-9+\\/]{3}=|[A-Za-z0-9+\\/]{2}={2})");

// Returns a welcome message on /api
// Ideally, this would hang at / rather than /api but I couldn't figure out nginx
// It will be super fun once this lands on apache2 and then I'll have to figure out how to make this
// work in my nginx docker env AND on a shared apache host
$router->get('/api', function () use ($router) {
    return response()->json(["application" => env('APP_NAME'), "version" => env('APP_VERSION')]);
});

// A grouping just collects settings for a set of routes as a convenience.
// These are the tournament routes, hence prepended with api/tournament
$router->group(['prefix' => 'api/tournament'], function() use ($router) {

    $router->get('/meta/games', function() use ($router) {
        return response()->json(["Amtgard","Belegarth","Dagorhir","Darkon","Other"]);
    });

    $router->get('/meta/search/{game}/major/{name}', function($game, $name) use ($router) {
        return response()->json([0 => $name]);
    });

    $router->get('/meta/search/{game}/minor/{name}', function($game, $name) use ($router) {

    });

    $router->post('/', function () use ($router) {
        return "new tournament";
    });

});

// The reviews endpoint group
$router->group(['prefix' => 'api/reviews'], function() use ($router) {

    $router->get('/', function() use ($router) {
        return "Review API";
    });

    $router->post('/review', function () use ($router) {
        // heredoc format still supported by PHP after all these many years
        return
<<<REVIEW
        review json
REVIEW;
    });

    $router->get('/review/{id:' . BASE64_GUID_PATTERN . '}', function ($id) use ($router) {
        return response()->json([
            new class { 
                public $at = 2000;
                public $action = "pause";
            }
        ]);
    });

    $router->put('/review/{id:' . BASE64_GUID_PATTERN . '}', function ($id) use ($router) {
        return
<<<REVIEW
        review json
REVIEW;
    });

    $router->get('/search/{search}', function($search) use ($router) {
        return "Search by $search";
    });

    $router->get('/reviews[/{page:\d+}]', function($page = 0) use ($router) {
        return "Page $page of user's reviews";
    });

    $router->get('/reviews/for/{user:' . BASE64_GUID_PATTERN . '}[/{page:\d+}]', function($user, $page = 0) use ($router) {
        return "Page $page of reviews for user $user";
    });

    $router->put('/{id:\d+}/comment', function($search) use ($router) {
        return "Search by $search";
    });

});
