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

Route::get('/', function() {
    $has_visited = Cookie::get('has_visited');

    if(!$has_visited) {
        Cookie::queue(Cookie::forever('has_visited', true));
    }

    return view('index', [
        'has_visited' => $has_visited
    ]);
})->name('index');

Route::get('/help', function() {
    if( \App::getLocale() === 'en' ){
        return view('pages.help-en');
    } elseif( \App::getLocale() === 'es' ){
        return view('pages.help-es');
    }
})->name('help');

// OAuth Routes
$s = 'social.';

Route::get('social/redirect/{provider}', [
  'as' => $s . 'redirect', 
  'uses' => 'Auth\SocialController@getSocialRedirect'
]);

Route::get('social/handle/{provider}', [
  'as' => $s . 'hanlde',
  'uses' => 'Auth\SocialController@getSocialHandle'
]);

Route::group(['middleware' => 'auth:all'], function() {
    $a = 'authenticated.';
    Route::get('/logout', ['as' => $a . 'logout', 'uses' => 'Auth\LoginController@logout']);
    Route::get('/activate/{token}', ['as' => $a . 'activate', 'uses' => 'ActivateController@activate']);
    Route::get('/activate', ['as' => $a . 'activation-resend', 'uses' => 'ActivateController@resend']);
    Route::get('not-activated', ['as' => 'not-activated', 'uses' => function () {
        return view('errors.not-activated');
    }]);
});

Auth::routes(['login' => 'auth.login']);

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/');
});

// Routes for the App
//
/**
 * The form for creating new posts
 */
Route::get('/popup', function(){
  return view('partials.popup');
})->middleware('auth');

/**
 * Simple page that has facebook and google login links
 */
Route::get('/partials/social-login', function(){
  return view('partials.social-login');
});

/**
 * Site About Us page
 */
Route::get('/about', function(){
    return view('pages.about');
})->name('about');

/**
 * Get and retrieve a post image
 */
Route::post('/post/image', [
  'as' => 'post.image.create',
  'uses' => 'PostImageController@create'
])->middleware('auth');;

Route::get('/post/image', [
  'as' => 'post.image',
  'uses' => 'PostImageController@get'
]);

/**
 * Post Controllers
 */

Route::post('/post/{id}', [
  'as' => 'post.update', 
  'uses' => 'PostController@update'
])->middleware('auth');;

Route::post('/post/{id}/delete', [
  'as' => 'post.delete', 
  'uses' => 'PostController@delete'
])->middleware('auth');;

Route::post('/post', [
  'as' => 'post.create', 
  'uses' => 'PostController@create'
])->middleware('auth');;

Route::get('/post', [
  'as' => 'post', 
  'uses' => 'PostController@get'
]);

/**
 * Survey Controllers
 */
Route::get('/survey', [
  'as' => 'survey',
  'uses' => 'SurveyController@get'
])->middleware('auth');


Route::post('/survey', [
  'as' => 'survey.create',
  'uses' => 'SurveyController@create'
])->middleware('auth');


/**
 * User Controllers
 */
Route::get('user/{id}', 'UserController@show')->name('user.profile');
Route::get('user', 'UserController@index')->name('users');

/**
 * Admin Controllers
 */
