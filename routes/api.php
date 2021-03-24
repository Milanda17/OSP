<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/getTickets', 'TicketController@getTickets');
    Route::post('/searchTicketByName', 'TicketController@searchTicketByName');
    Route::post('/createReply', 'TicketController@createReply');
    Route::post('/updateTicketStatus', 'TicketController@updateTicketStatus');
});
Route::post('/createTicket', 'TicketController@createTicket');
Route::post('/searchTicketById', 'TicketController@searchTicketById');

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::post('/logout', 'AuthController@logout');

