<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class PostModelTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $m = new User();
        $this->assertEquals([
            'username',
            'email',
            'email_verified_at',
            'password',
            'fullname',
            'image_path',
            'phone',
            'birthday',
            'gender',
            'address',
            'status',
            'role_id',
        ], $m->getFillable());
    }
}
