<?php

Route::get('/', 'HomeController@index')->name('home');

Route::get('movies', 'MovieController@index')->name('movies');
Route::post('movies', 'MovieController@store');

Route::get('imdb', 'ImdbController@index')->name('imdb');
Route::get('imdb/{imdb_id}', 'ImdbController@show')->name('imdb.show');


