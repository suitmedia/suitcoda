<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(ScopeTableSeeder::class);
        $this->call(SubScopeTableSeeder::class);
        $this->call(CommandsTableSeeder::class);

        Model::reguard();
    }
}
