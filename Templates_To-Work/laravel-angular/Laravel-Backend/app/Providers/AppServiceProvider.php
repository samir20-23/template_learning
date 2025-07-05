<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Validation;
use App\Policies\UserPolicy;
use App\Models\Document; 
use App\Models\Categorie; 

use App\Policies\DocumentPolicy;
use App\Policies\CategoriePolicy;
use App\Policies\ValidationPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
protected $policies = [
    User::class => UserPolicy::class,
    Validation::class => ValidationPolicy::class,
     Document::class => DocumentPolicy::class, // already done
     Categorie::class => CategoriePolicy::class, // if needed
];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


    public function boot()
    {
        Paginator::useBootstrap();
    }

}
