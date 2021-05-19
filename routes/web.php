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

Route::get('/', function () {
    return view('welcome');
});

// Put this inside either the POST route '/<token>/webhook' closure (see below) or 
// whatever Controller is handling your POST route
$updates = Telegram::getWebhookUpdates();

// Example of POST Route:
Route::post('/telegram/webhook', function () {
    $updates = Telegram::getWebhookUpdates();

    return 'ok';
});

// !!IMPORTANT!!
/* 
You need to add your route in "$except" array inside the app/Http/Middleware/VerifyCsrfToken.php file in order to bypass the CSRF Token verification process that takes place whenever a POST route is called.

Example:

protected $except = [
    '/<token>/webhook'
];
*/

Route::get('telegram/test',function(){
    $response = Telegram::getMe();

    $botId = $response->getId();
    $firstName = $response->getFirstName();
    $username = $response->getUsername();
    return (array($firstName,$username));

});
