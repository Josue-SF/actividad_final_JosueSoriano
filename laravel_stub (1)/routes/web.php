
<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function(){ return view('index'); });
Route::get('/artists', function(){ return view('artists'); });
Route::get('/register', function(){ return view('register'); });
Route::get('/schedule', function(){ return view('schedule'); });
Route::get('/venue', function(){ return view('venue'); });
