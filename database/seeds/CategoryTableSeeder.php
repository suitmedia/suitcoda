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
            'label' => 'blue',
            'directory' => 'seo/'
        ]);
        factory(Category::class, 'seeder')->create([
            'name' => 'Performance',
            'label' => 'orange',
            'directory' => 'performance/'
        ]);
        factory(Category::class, 'seeder')->create([
            'name' => 'Code Quality',
            'label' => 'red',
            'directory' => 'linter/'
        ]);
        factory(Category::class, 'seeder')->create([
            'name' => 'Social Media',
            'label' => 'green',
            'directory' => 'socmed/'
        ]);
    }
}
