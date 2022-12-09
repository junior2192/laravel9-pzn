<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class serviceContainerTest extends TestCase
{
    public function testDependency()
    {
        $foo1 = $this->app->make(Foo::class); //new foo()
        $foo2 = $this->app->make(Foo::class); //new foo()

        self::assertEquals("Foo", $foo1->foo());
        self::assertEquals("Foo", $foo2->foo());
        self::assertNotSame($foo1, $foo2);
    }

    public function testBind()
    {
        $this->app->bind(Person::class, function($app){
            return new Person('Eko', 'Khannedy');
        });


        $person1 = $this->app->make(Person::class); //closure()
        $person2 = $this->app->make(Person::class); //closure()

        self::assertEquals('Eko', $person1->firstname);
        self::assertEquals('Eko', $person2->firstname);
        self::assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function($app){
            return new Person('Eko', 'Khannedy');
        });


        $person1 = $this->app->make(Person::class); //new Person("eko), "Khannedy); if not exist
        $person2 = $this->app->make(Person::class); //return existing
        $person3 = $this->app->make(Person::class); //return existing
        $person4 = $this->app->make(Person::class); //return existing


        self::assertEquals('Eko', $person1->firstname);
        self::assertEquals('Eko', $person2->firstname);
        self::assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person("Eko", "Khannedy");
        $this->app->instance(Person::class, $person);


        $person1 = $this->app->make(Person::class); // $person
        $person2 = $this->app->make(Person::class); // $person
        $person3 = $this->app->make(Person::class); // $person
        $person4 = $this->app->make(Person::class); // $person


        self::assertEquals('Eko', $person1->firstname);
        self::assertEquals('Eko', $person2->firstname);
        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function($app){
            return new Foo();
        });

        $this->app->singleton(Bar::class, function($app){
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);

        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        //bisa ini
        //$this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        //atau ini
        $this->app->singleton(HelloService::class, function ($app){
            return new HelloServiceIndonesia();
        });

        $halloService = $this->app->make(HelloService::class);

        self::assertEquals("Hallo Eko", $halloService->hello("Eko"));
    }
}
