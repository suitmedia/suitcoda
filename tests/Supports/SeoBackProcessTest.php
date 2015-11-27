<?php

namespace SuitTests\Supports;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Model\Project;
use Suitcoda\Model\Url;
use Suitcoda\Model\User;
use Suitcoda\Supports\SeoBackProcess;
use SuitTests\TestCase;

class SeoBackProcessTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Test run method
     *
     * @return void
     */
    public function testRun()
    {
        factory(Url::class, 5)->create();

        $destination = 'public/test/project/example/1/';
        $option = [
            'title-similar' => true,
            'desc-similar' => true,
            'depth' => true
        ];

        $url = new Url;
        $checker = new SeoBackProcess($url);
        
        $checker->setUrl('http://example.com/test');
        $checker->setDestination($destination);
        $checker->setOption($option);
        $checker->run();

        unlink(base_path($destination) . 'resultBackendSEO.json');
        if (is_dir(base_path($destination))) {
            rmdir(base_path('public/test/project/example/1'));
            rmdir(base_path('public/test/project/example'));
            rmdir(base_path('public/test/project'));
            rmdir(base_path('public/test'));
        }
    }
}
