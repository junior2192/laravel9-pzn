<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloControlerTest extends TestCase
{
    public function testHello()
    {
        $this->get('/controller/hello/Eko')
            ->assertSeeText('Hallo Eko');
    }
}
