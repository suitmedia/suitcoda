<?php

namespace Suitcoda\Console\Commands;

use Illuminate\Console\Command;
use Suitcoda\Model\User;

class NewUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:new-superuser {username} {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create New User.';

    protected $user;

    /**
     * Create a new command instance.
     *
     * @param Suitcoda\Model\User $user []
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $username = $this->argument('username');
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        $admin = $this->user->newInstance();
        $admin->username = $username;
        $admin->name = $name;
        $admin->email = $email;
        $admin->password = bcrypt($password);
        $admin->is_admin = true;
        $admin->is_active = true;

        if ($admin->save()) {
            $this->info('New Admin has been successfully created!!');
        }
    }
}
