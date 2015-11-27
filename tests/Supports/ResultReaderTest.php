<?php

namespace SuitTests\Supports;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Model\Issue;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Scope;
use SuitTests\TestCase;
use Webmozart\Json\JsonDecoder;

class ResultReaderTest extends TestCase
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

    public function testCallSeoResultReaderForSeo()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 1)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = Mockery::mock('Suitcoda\Supports\ResultReader[seoResultReader]', [$decoder, $issue]);

        $reader->shouldReceive('seoResultReader')->once();

        $reader->setJob($jobFaker);
        $reader->run();
    }

    public function testCallSeoResultReaderForBackendSeo()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 2)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = Mockery::mock('Suitcoda\Supports\ResultReader[seoResultReader]', [$decoder, $issue]);

        $reader->shouldReceive('seoResultReader')->once();

        $reader->setJob($jobFaker);
        $reader->run();
    }

    public function testCallSeoResultReaderForHtml()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 3)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = Mockery::mock('Suitcoda\Supports\ResultReader[htmlResultReader]', [$decoder, $issue]);

        $reader->shouldReceive('htmlResultReader')->once();

        $reader->setJob($jobFaker);
        $reader->run();
    }

    public function testCallSeoResultReaderForCss()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 4)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = Mockery::mock('Suitcoda\Supports\ResultReader[cssResultReader]', [$decoder, $issue]);

        $reader->shouldReceive('cssResultReader')->once();

        $reader->setJob($jobFaker);
        $reader->run();
    }

    public function testCallSeoResultReaderForJs()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 5)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = Mockery::mock('Suitcoda\Supports\ResultReader[jsResultReader]', [$decoder, $issue]);

        $reader->shouldReceive('jsResultReader')->once();

        $reader->setJob($jobFaker);
        $reader->run();
    }

    public function testCallSeoResultReaderForSocialMedia()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 6)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = Mockery::mock('Suitcoda\Supports\ResultReader[socialMediaResultReader]', [$decoder, $issue]);

        $reader->shouldReceive('socialMediaResultReader')->once();

        $reader->setJob($jobFaker);
        $reader->run();
    }

    public function testCallSeoResultReaderForPagespeedDesktop()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 7)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = Mockery::mock('Suitcoda\Supports\ResultReader[gPagespeedResultReader]', [$decoder, $issue]);

        $reader->shouldReceive('gPagespeedResultReader')->once();

        $reader->setJob($jobFaker);
        $reader->run();
    }

    public function testCallSeoResultReaderForPagespeedMobile()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 8)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = Mockery::mock('Suitcoda\Supports\ResultReader[gPagespeedResultReader]', [$decoder, $issue]);

        $reader->shouldReceive('gPagespeedResultReader')->once();

        $reader->setJob($jobFaker);
        $reader->run();
    }

    public function testCallSeoResultReaderForYslow()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 9)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = Mockery::mock('Suitcoda\Supports\ResultReader[ySlowResultReader]', [$decoder, $issue]);

        $reader->shouldReceive('ySlowResultReader')->once();

        $reader->setJob($jobFaker);
        $reader->run();
    }
}
