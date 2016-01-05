<?php

use Illuminate\Database\Seeder;
use Suitcoda\Model\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 'seeder')->create([
            'name' => 'SEO',
            'slug' => 'seo',
            'label_color' => 'blue',
            'directory' => 'seo/'
        ]);
        factory(Category::class, 'seeder')->create([
            'name' => 'Performance',
            'slug' => 'performance',
            'label_color' => 'orange',
            'directory' => 'performance/'
        ]);
        factory(Category::class, 'seeder')->create([
            'name' => 'Code Quality',
            'slug' => 'code-quality',
            'label_color' => 'red',
            'directory' => 'linter/'
        ]);
        factory(Category::class, 'seeder')->create([
            'name' => 'Social Media',
            'slug' => 'social-media',
            'label_color' => 'green',
            'directory' => 'socmed/'
        ]);
    }
}
