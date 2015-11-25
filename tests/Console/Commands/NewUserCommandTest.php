<?php

namespace SuitTests\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Console\Commands\NewUserCommand;
use SuitTests\TestCase;

/**
 * Test Suitcoda\Console\Commands\NewUserCommand
 */

class NewUserCommandTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * test continue if user success save to database
     *
     * @return void
     */
    public function testCommandHasBeenSaveInDatabase()
    {
        $this->artisan('user:new-superuser', [
            'username' => 'foo',
            'name' => 'Foo bar',
            'email' => 'foo@bar.com',
            'password' => 'foobar'
        ]);
        $this->seeInDatabase('users', [
            'username' => 'foo',
        ]);
    }
}
