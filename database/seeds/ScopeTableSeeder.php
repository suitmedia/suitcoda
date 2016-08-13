<?php

use Illuminate\Database\Seeder;
use Suitcoda\Model\Category;
use Suitcoda\Model\Scope;
use Suitcoda\Supports\CrawlerUrl;

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
            'socialMedia' => 'Social Media',
            'gPagespeedDesktop' => 'Performance',
            'gPagespeedMobile' => 'Performance',
            'ySlow' => 'Performance',
        ];

        foreach ($scopesList as $name => $category) {
            if (strcmp($name, CrawlerUrl::CSS) == 0) {
                $type = CrawlerUrl::CSS;
            } elseif (strcmp($name, CrawlerUrl::JS) == 0) {
                $type = CrawlerUrl::JS;
            } else {
                $type = CrawlerUrl::HTML;
            }
            factory(Scope::class, 'seeder')->create([
                'name' => $name,
                'category_id' => Category::byName($category)->first()->id,
                'type' => $type
            ]);
        }
    }
}
