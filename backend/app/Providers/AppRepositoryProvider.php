<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\RecordRepositoryInterface;
use App\Repositories\Contracts\ClassroomRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\ActivityRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;

use App\Repositories\RecordRepository;
use App\Repositories\ClassroomRepository;
use App\Repositories\UserRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\StudentRepository;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton( RecordRepositoryInterface::class, RecordRepository::class );
        $this->app->singleton( ClassroomRepositoryInterface::class, ClassroomRepository::class );
        $this->app->singleton( UserRepositoryInterface::class, UserRepository::class );
        $this->app->singleton( ActivityRepositoryInterface::class, ActivityRepository::class );
        $this->app->singleton( StudentRepositoryInterface::class, StudentRepository::class );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
