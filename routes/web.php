<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Models\Person;
use Illuminate\Support\Facades\DB;

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
Route::get('/people', [PersonController::class, 'index'])->name('people.index');
Route::get('/people/create', [PersonController::class, 'create'])->name('people.create')->middleware('auth');
Route::post('/people', [PersonController::class, 'store'])->name('people.store')->middleware('auth');
Route::get('/people/{id}', [PersonController::class, 'show'])->name('people.show');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test-degre', function () {
    DB::enableQueryLog();
    $timestart = microtime(true);

    $person = Person::findOrFail(84);
    $degree = $person->getDegreeWith(1265);

    $elapsed = microtime(true) - $timestart;
    $queries = DB::getQueryLog();

    dd([
        'degree' => $degree,
        'time' => $elapsed,
        'nb_queries' => count($queries),
    ]);
});
