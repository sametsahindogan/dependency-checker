# dependency-checker

[![GitHub license](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://raw.githubusercontent.com/sametsahindogan/laravel-jwtredis/master/LICENSE)

> This project checks the NPM and Packagist dependencies of the added public Github and Bitbucket repository.

<a><img src="https://poeditor.com/blog/wp-content/uploads/2014/06/bitbucket-logo.png" width="110"></a>
<a><img src="http://pngimg.com/uploads/github/github_PNG83.png" width="100"></a>

## Preview

Repositories;
<br>
<a><img src="https://raw.githubusercontent.com/sametsahindogan/dependency-checker/master/public/start-ui/img/git1.png"></a>
<br>
Details;
<br>
<a><img src="https://raw.githubusercontent.com/sametsahindogan/dependency-checker/master/public/start-ui/img/git2.png"></a>

## About Project

After making the necessary configurations;

*`php artisan build` => Autoload, migration, seeding and created test user.

*`php artisan queue:work --sleep=2 --tries=3` => Do not forget to work queue.

## How It Works?

After the added repository is checked in Git provider API, it is assigned to the queue for the necessary dependency check operations. There is a Log service which monitors the Repository model for these operations.
For all repositories, a daily scheduled task is run and fetch the latest project version at the Git provider API. Then rechecked from the NPM and Packagist service. If any outdated dependency is found, it is marked as outdated project then throw email notification.

## Design Patterns

Factory, Singleton, Observer, Decorator

