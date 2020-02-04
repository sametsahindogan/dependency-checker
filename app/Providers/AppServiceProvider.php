<?php

namespace App\Providers;

use App\Models\Repository;
use App\Observers\BaseObserver;
use App\Services\ApiService\DependencyFactory;
use App\Services\CompareService\Compare;
use App\Services\CompareService\CompareInterface;
use App\Services\GitService\GitFactory;
use App\Services\JsonResponseService\ResponseBuilderInterface;
use App\Services\LogService\Interfaces\LogServiceInterface;
use App\Services\LogService\LogService;
use App\Services\JsonResponseService\ResponseBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Get all observerable models of application.
     * @var array $observableModels
     */
    protected $observableModels = [
        Repository::class
    ];

    /**
     * Get all singleton bind class of application.
     * @var array $singletonBindings
     */
    protected $singletonBindings = [
        ResponseBuilderInterface::class => ResponseBuilder::class,
        GitFactory::class => GitFactory::class,
        DependencyFactory::class => DependencyFactory::class,
        CompareInterface::class => Compare::class,
        LogServiceInterface::class => LogService::class,
    ];

    /**
     * Get all bindable class of application.
     * @var array $bindings
     */
    protected $dependencyBindings = [
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->singletonBindings as $need => $give) {
            $this->app->singleton($need, function ($app) use ($give) {
                return new $give();
            });
        }

        foreach ($this->dependencyBindings as $need => $give) {
            $this->app->bind($need, function ($app) use ($give) {
                return new $give[0]($give[1]);
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var Model $model */
        foreach ($this->observableModels as $model) {
            $model::observe(BaseObserver::class);
        }
    }
}
