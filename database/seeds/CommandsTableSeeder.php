<?php

use Illuminate\Database\Seeder;
use Suitcoda\Model\Command;
use Suitcoda\Model\Scope;

class CommandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            'seo' => 'seoChecker.js',
            'backendSeo' => 'php artisan checker:backend-seo',
            'html' => 'htmlHorseman.js',
            'css' => 'cssHorseman.js',
            'js' => 'jsHorseman.js',
            'socialMedia' => 'socmedChecker.js',
            'gPagespeed' => 'pagespeed.js',
            'ySlow' => 'yslowHorseman.js'
        ];

        foreach ($list as $name => $commandLine) {
            $scope = Scope::getByName($name);

            $model = factory(Command::class)->make([
                'name' => $name,
                'command_line' => $commandLine
            ]);
            $model->scope()->associate($scope);
            $model->save();
        }
    }
}
