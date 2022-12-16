<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Eko')
            ->assertSeeText('Hello Eko');

        $this->post('/input/hello', [
            'name' => 'Eko'
        ])->assertSeeText('Hello Eko');
    }

    public function testInputNested()
    {
        $this->post('/input/hello', [
            'name' => [
                'first' => 'Eko',
                'last' => 'Khannedy'
            ]
        ])->assertSeeText('Hello Eko');
    }

    public function testHelloInput()
    {
        $this->post('/input/hello/input', [
            'name' => [
                'first' => 'Eko',
                'last' => 'Khannedy'
            ]
        ])->assertSeeText('name')
            ->assertSeeText('first')
            ->assertSeeText('last');
    }

}
