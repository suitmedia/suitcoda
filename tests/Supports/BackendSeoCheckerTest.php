<?php

namespace SuitTests\Supports;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Model\Project;
use Suitcoda\Model\Url;
use Suitcoda\Model\User;
use Suitcoda\Supports\BackendSeoChecker;

class BackendSeoCheckerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testRun()
    {
        $this->addUrlFaker();
        $destination = '/public/files/project/example/1/';
        $option = [
            'title-similar' => true,
            'desc-similar' => true,
            'depth' => true
        ];

        $url = new Url;
        $checker = new BackendSeoChecker($url);
        
        $checker->setUrl('http://example.com/test');
        $checker->setDestination($destination);
        $checker->setOption($option);
        $checker->run();

        unlink(base_path($destination) . 'resultBackendSEO.json');
        if (is_dir(base_path($destination))) {
            rmdir(base_path('/public/files/project/example/1'));
            rmdir(base_path('/public/files/project/example'));
            rmdir(base_path('/public/files/project'));
            rmdir(base_path('/public/files'));
        }
    }

    protected function addUrlFaker()
    {
        $userFaker = factory(User::class)->create(['name' => 'test']);
        $projectFaker = factory(Project::class)->make();
        $userFaker->projects()->save($projectFaker);
        for ($i=0; $i < 2; $i++) {
            $urlFaker = factory(Url::class)->make();
            $projectFaker->urls()->save($urlFaker);
        }
    }
}
