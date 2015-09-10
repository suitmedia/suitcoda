<?php

namespace Suitcoda\Console\Commands;

use Illuminate\Console\Command;

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

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
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

        $adminClass = \Config::get('auth.model');
        $admin = new $adminClass();
        $admin->username = $username;
        $admin->name = $name;
        $admin->email = $email;
        $admin->password = $password;
        $admin->is_admin = true;
        $admin->is_active = true;

        if ($admin->save()) {
            $this->info('New Admin has been successfully created!!');
        }
    }
}
