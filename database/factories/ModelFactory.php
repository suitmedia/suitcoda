<?php

use Suitcoda\Model\Command;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Project;
use Suitcoda\Model\Scope;
use Suitcoda\Model\SubScope;
use Suitcoda\Model\Url;
use Suitcoda\Model\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(User::class, function ($faker) {
    return [
        'username' => $faker->sentence($nbWords = 3),
        'email' => $faker->email,
        'password' => bcrypt($faker->word),
        'name' => $faker->name,
        'slug' => $faker->slug,
        'is_admin' => $faker->boolean,
        'is_active' => true,
        'last_login_at' => \Carbon\Carbon::now()
    ];
});

$factory->define(Project::class, function ($faker) {
    $sentence = $faker->sentence($nbWords = 6);
    return [
        'name' => $sentence,
        'slug' => $sentence,
        'main_url' => 'http://' . $sentence . '.com',
        'is_crawlable' => true,
        'user_id' => factory(User::class)->create()->id
    ];
});

$factory->define(Inspection::class, function ($faker) {
    return [
        'sequence_number' => 1,
        'scopes' => 256,
        'status' => 0,
        'project_id' => factory(Project::class)->create()->id
    ];
});

$factory->define(Scope::class, function ($faker) {
    return [
        'name' => 'test',
        'type' => 't1',
        'is_active' => true
    ];
});

$factory->define(SubScope::class, function ($faker) {
    return [
        'name' => 'test',
        'code' => 1,
        'parameter' => '--test',
        'is_active' => true,
        'scope_id' => factory(Scope::class)->create()->id,
    ];
});

$factory->define(Command::class, function ($faker) {
    return [
        'name' => 'test',
        'command_line' => 'test',
        'is_active' => true,
        'scope_id' => factory(Scope::class)->create()->id,
    ];
});

$factory->define(Url::class, function ($faker) {
    return [
        'type' => 'url',
        'url' => 'http://example.com/test',
        'depth' => 4,
        'title' => 'test',
        'title_tag' => '<title>test</title>',
        'desc' => 'this is testing',
        'desc_tag' => '<meta name="description" content"this is testing"/>',
        'body_content' => '',
        'is_active' => true,
        'project_id' => factory(Project::class)->create()->id
    ];
});

$factory->define(JobInspect::class, function ($faker) {
    return [
        'command_line' => 'test',
        'inspection_id' => factory(Inspection::class)->create()->id,
        'url_id' => factory(Url::class)->create()->id,
        'scope_id' => factory(Scope::class)->create()->id,
    ];
});
