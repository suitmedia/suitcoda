<?php

namespace SuitTests\Supports;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use SuitTests\TestCase;
use Suitcoda\Model\Inspection;
use Suitcoda\Model\Project;
use Suitcoda\Model\Scope;
use Suitcoda\Model\Url;
use Suitcoda\Supports\ScopesCheckerGenerator;

class ScopesCheckerGeneratorTest extends TestCase
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

    public function testGenerateUrl()
    {
        $urlFaker = factory(Url::class)->make();

        $scope = Mockery::mock(Scope::class)->makePartial();

        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateUrl($urlFaker);
        $this->assertEquals(' --url ' . $urlFaker->url, $result);
    }

    public function testGenerateDestination()
    {
        $inspectionFaker = factory(Inspection::class)->make();
        $projectFaker = factory(Project::class)->make();

        $scope = Mockery::mock(Scope::class)->makePartial();

        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateDestination($projectFaker, $inspectionFaker);
        $this->assertEquals(
            ' --destination public/files/' .
            $projectFaker->name . '/' .
            $inspectionFaker->sequence_number . '/ ',
            $result
        );
    }

    public function testGetSubDirCommand()
    {
        $scope = Mockery::mock(Scope::class)->makePartial();

        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->getSubDirCommand('SEO');
        $this->assertEquals('seo/', $result);
    }

    public function testGenerateParameters()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateParameters('256', 'seo');
        $this->assertEquals('--heading', $result);
    }

    public function testGenerateCommand()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateCommand('2097151', 'seo');
        $this->assertEquals('nodejs seo/seoChecker.js', $result);
    }

    public function testGenerateCommandBackendSeo()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateCommand('2097151', 'backendSeo');
        $this->assertEquals('php artisan checker:backend-seo', $result);
    }

    public function testGenerateCommandNull()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->generateCommand('0', 'seo');
        $this->assertNull($result);
    }

    public function testGetTyType()
    {
        $scope = new Scope;
        $checker = new ScopesCheckerGenerator($scope);

        $result = $checker->getByType('css');
        $this->assertInstanceOf(Scope::class, $result->first());
    }
}
