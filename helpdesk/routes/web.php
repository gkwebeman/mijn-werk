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

Route::get('/ticket/create', 'TicketController@create')->name('ticket_create');

Route::post('/ticket/save', 'TicketController@save')->name('ticket_save');

Route::get('/ticket/index_customer', 'TicketController@index')->name('ticket_index_customer');

Route::get('/ticket/{id}/show', 'TicketController@show')->where('id', '[1-9][0-9]*')->name('ticket_show');

Route::post('/ticket/{id}/comment/save', 'CommentController@save')->where('id', '[1-9][0-9]*')->name('comment_save');

Route::get('/ticket/index_helpdesk', 'TicketController@index_helpdesk')->name('ticket_index_helpdesk');

Route::put('/ticket/{id}/close', 'TicketController@close')->where('id', '[1-9][0-9]*')->name('ticket_close');

Route::put('/ticket/{id}/claim', 'TicketController@claim')->where('id', '[1-9][0-9]*')->name('ticket_claim');

Route::put('/ticket/{id}/free', 'TicketController@free')->where('id', '[1-9][0-9]*')->name('ticket_free');

Route::put('/ticket/{id}/escalate', 'TicketController@escalate')->where('id', '[1-9][0-9]*')->name('ticket_escalate');

Route::put('/ticket/{id}/deescalate', 'TicketController@deescalate')->where('id', '[1-9][0-9]*')->name('ticket_deescalate');

Route::put('/ticket/{id}/delegate', 'TicketController@delegate')->where('id', '[1-9][0-9]*')->name('ticket_delegate');



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dit/is/een/test', 'TestController@simpeleTest');

Route::get('/param/{id}', 'TestController@testParam')->where('id', '[1-9][0-9]*');

Route::get('/dit/is/test2', function() {
    return view('test2')->with('varnaam', config('database.default'));
});

Route::get('/index', 'TestController@index');

Route::get('/product/{id}', 'TestController@product')->where('id', '[1-9][0-9]*');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
