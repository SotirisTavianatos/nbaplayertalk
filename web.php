<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CustomAuthController;

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

Route::resource('/comment',CommentController::class);
//->middleware('throttle:comment');


Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');


Route::get('/nbaplayertalk', [CommentController::class, 'home']); 
Route::get('/team/{teamname}',[CommentController::class,'teaminfo']);
Route::get('/player/{playername}',[CommentController::class,'playerinfo']);
Route::get('/allcomments',[CommentController::class,'allcomments']);
Route::get('/mycomments',[CommentController::class,'mycomments']);
Route::post('/like/{cid}',[CommentController::class,'like']);
Route::post('/dislike/{cid}',[CommentController::class,'dislike']);
Route::get('/currentroster/{teamname}',[CommentController::class,'currentroster']);
Route::get('/roster/{year}/{teamname}',[CommentController::class,'yearroster']);
