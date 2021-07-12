<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Isbn\Isbn;
use Symfony\Component\ErrorHandler\Debug;
use Zip;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Isbn::class, function () {
            return new Isbn();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Relation::morphMap([
            'book_collection' => 'App\Models\BookCollection',
            'book_section' => 'App\Models\BookSection',
        ]);
    }
}
