<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('verify', function (){
    $response = Http::get('http://laravel-ng.test/api/envato/verify/86781236-23d0-4b3c-7dfa-c1c147e0dece');

    if ($response->successful()) {
        $data = $response->json();
        dump($data);
    } else {
        $error = $response->body();
        dump($error);
    }
});

Route::get('/', function () {
    return view('welcome');
});
