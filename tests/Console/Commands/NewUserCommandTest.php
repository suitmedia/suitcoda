<?php

namespace SuitTests\Console\Commands;

use Mockery;
use Suitcoda\Console\Commands\NewUserCommand;
use Illuminate\Console\Command;
use SuitTests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Test Suitcoda\Console\Commands\NewUserCommand
 */

class NewUserCommandTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * test continue if user success save to database
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
