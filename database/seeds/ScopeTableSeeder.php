<?php

use Illuminate\Database\Seeder;
use Suitcoda\Model\Scope;

class ScopeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scopesList = [
            'seo' => 'SEO',
            'backendSeo' => 'SEO',
            'html' => 'Code Quality',
            'css' => 'Code Quality',
            'js' => 'Code Quality',
            'socialMedia' => 'Sosial Media',
            'gPagespeed' => 'Performance',
            'ySlow' => 'Performance',
        ];

        foreach ($scopesList as $name => $category) {
            if (strcmp($name, 'css') == 0) {
                $type = 'css';
            } elseif (strcmp($name, 'js') == 0) {
                $type = 'js';
            } else {
                $type = 'url';
            }
            factory(Scope::class)->create([
                'name' => $name,
                'category' => $category,
                'type' => $type
            ]);
        }
    }
}
