<?php

namespace Tests\Unit\App\Http\Controllers\Consumer;

use App\Model\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http|Controllers\Consumer\Authentication
 */
class AuthenticationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * @covers ::register
     */
    public function can_register()
    {
        $this->visit(route('consumer.auth.register'))
            ->type('New Guy', 'name')
            ->type('newguy@finternet-group.com', 'email')
            ->type('testtest', 'password')
            ->press('Create');

        $users = User::where('email', 'newguy@finternet-group.com')->get();

        $this->assertCount(1, $users);
        $this->assertTrue(is_numeric($users->first()->id));
    }
}