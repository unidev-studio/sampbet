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

Route::get('/', 'Main@index');
Route::get('/about', 'Main@about');
Route::get('/rates', 'Main@rates');
Route::get('/rules', 'Main@rules');
Route::get('/contacts', 'Main@contacts');
Route::get('/docs', 'Main@docs');
Route::get('/docs/{page}', 'Main@docs');
Route::get('/referal/{id}', 'Main@referal_action');
Route::get('/register', 'Main@register');
Route::get('/sessions/{id}', 'Main@sessions');
Route::get('/panel', 'Main@auth');
Route::get('/panel/settings', 'Main@settings');
Route::get('/panel/data/{service}', array('uses' => 'Systems@getChannelData'));
Route::get('/panel/personalization', 'Main@personalization');
Route::get('/panel/transactions', 'Main@transactions');
Route::get('/panel/draw', 'Main@draw');
Route::get('/panel/withdraw', 'Main@withdraw');
Route::get('/panel/referal', 'Main@referal');
Route::get('/panel/moderation/{name}', 'Main@moderation');
Route::get('/panel/settings', 'Main@settings');
Route::get('/panel/exit', 'Main@exit');

Route::get('/c/{ident}', 'Main@board');
Route::get('/wallet/{status}', 'Main@wallet');

// route to process the form
Route::post('/panel', array('uses' => 'Systems@AuthProcess'));
Route::post('/register', array('uses' => 'Systems@RegisterProcess'));
Route::post('/settings/{id}', array('uses' => 'Systems@SettingsProcess'));
Route::post('/withdraw/{id}', array('uses' => 'Systems@WithdrawProcess'));
Route::get('/register/verif/{code}', array('uses' => 'Systems@VerifProcess'));
Route::post('/wallet/{id}', array('uses' => 'Systems@WalletGenerate'));

// ajax
Route::post('/use/{name}', array('uses' => 'Systems@API'));
Route::post('/moder/{name}', array('uses' => 'Systems@API_Moderation'));