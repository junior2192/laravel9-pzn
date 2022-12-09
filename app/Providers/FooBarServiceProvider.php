<?php

namespace App\Providers;

use App\Data\Bar;
use App\Data\Foo;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

//ditambahkan implements DeferrableProvider
//utk hanya yangdibutuhkan saja service providernya tidak di load semua
class FooBarServiceProvider extends ServiceProvider implements DeferrableProvider
{
    //ini jika kasusnya sangat sederhana
    //tidak ada codekompleks

    public array $singletons = [
      HelloService::class => HelloServiceIndonesia::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //percobaan defferd atau lazy
        //echo "FooBarServiceProvider";

        $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app){
            return new Bar($app->make(Foo::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    //diload ketika dibutuhkan
    //cocok utk service provider kalo sudah banyak
    //jadi tidak memberatkan laravel
    public function provides()
    {
        return [HelloService::class, Foo::class, Bar::class];
    }
}
