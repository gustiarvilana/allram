<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MathHelperTest extends TestCase
{
    public function testBasicAddition()
    {
        $response = $this->post('/add', [
            'a' => 2,
            'b' => 3,
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'result' => 5,
            ]);
    }
}
