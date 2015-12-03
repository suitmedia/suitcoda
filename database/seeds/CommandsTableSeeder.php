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
            'gPagespeedDesktop' => 'pagespeedDesktop.js',
            'gPagespeedMobile' => 'pagespeedMobile.js',
            'ySlow' => 'yslowHorseman.js'
        ];
        $scope = new Scope;

        foreach ($list as $name => $commandLine) {
            $scope = $scope::getByName($name);

            factory(Command::class, 'seeder')->create([
                'name' => $name,
                'command_line' => $commandLine,
                'scope_id' => $scope->id
            ]);
        }
    }
}
