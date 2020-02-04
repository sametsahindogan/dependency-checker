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

use App\Jobs\NotificationMailJob;
use App\Models\Dependency;
use App\Models\Repository;
use App\Services\ApiService\GithubService\GithubApiResponse;
use App\Services\ApiService\NpmService\NpmApiRequest;
use App\Services\ApiService\PackagistService\PackagistApiRequest;
use Composer\Semver\Comparator;
use \App\Services\ApiService\GithubService\GithubApiRequest;
use Illuminate\Support\Facades\Log;


Route::get('/logout', 'LoginController@logout')->name('logout');

Route::group(['middleware' => 'guest'], function () {

    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('login.post');

});

Route::group(['middleware' => 'authed'], function () {

    Route::get('/', function () { return redirect()->to(route('repositories')); })->name('home');

    Route::group(['prefix' => 'emails'], function () {

        Route::get('/', 'EmailController@index')->name('emails');
        Route::get('/list', 'EmailController@get')->name('emails.get');

        Route::get('/add', 'EmailController@createPage')->name('emails.createPage');
        Route::post('/add', 'EmailController@create')->name('emails.create');

        Route::get('/edit/{id}', 'EmailController@updatePage')->name('emails.updatePage');
        Route::post('/edit', 'EmailController@update')->name('emails.update');

        Route::get('/remove/{id}', 'EmailController@deletePage')->name('emails.deletePage');
        Route::post('/remove', 'EmailController@delete')->name('emails.delete');

    });

    Route::group(['prefix' => 'repositories'], function () {

        Route::get('/', 'GitRepositoryController@index')->name('repositories');

        Route::get('/list', 'GitRepositoryController@get')->name('repositories.get');

        Route::get('/add', 'GitRepositoryController@createPage')->name('repositories.createPage');

        Route::post('/add', 'GitRepositoryController@create')->name('repositories.create');

    });

    Route::group(['prefix' => 'dependencies'], function () {

        Route::group(['prefix' => '/{repo_slug}'], function () {

            Route::group(['prefix' => '/{project_slug}'], function () {

                Route::get('/', 'DependencyController@index')->name('dependencies');

                Route::get('/list', 'DependencyController@get')->name('dependencies.get');

            });
        });
    });
});

Route::get('/test', function () {

    $bitbucket = (new \App\Services\GitService\Bitbucket\BitbucketApiRequest());

    $bitbucket->getRepoWithDependencies('sametsahindogan/atolye15');

//    $bitbucket = (new \App\Services\GitService\Git\GitApiRequest());

//    $bitbucket->getRepoWithDependencies('sametsahindogan/laravel-jwtredis');

});
