<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;

use App\Repositories\TaskRepositoryInterface;
use App\Repositories\TaskRepository;

//REPOS USE
class TrainingProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            TaskRepositoryInterface::class,
            TaskRepository::class
        );
        //REPOS BIND END
    }
}
