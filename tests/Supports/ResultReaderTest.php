<?php

namespace SuitTests\Supports;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Suitcoda\Model\Issue;
use Suitcoda\Model\JobInspect;
use Suitcoda\Model\Scope;
use Suitcoda\Supports\ResultReader;
use SuitTests\TestCase;
use Webmozart\Json\FileNotFoundException;
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

    /**
     * Test to call seoResultReader method
     *
     * @return void
     */
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

    /**
     * Test to call seoResultReader method
     *
     * @return void
     */
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

    /**
     * Test to call htmlResultReader method
     *
     * @return void
     */
    public function testCallHtmlResultReader()
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

    /**
     * Test to call cssResultReader method
     *
     * @return void
     */
    public function testCallCssResultReader()
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

    /**
     * Test to call jsResultReader method
     *
     * @return void
     */
    public function testCallJsResultReader()
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

    /**
     * Test to call socialMediaResultReader method
     *
     * @return void
     */
    public function testCallSocialMediaResultReader()
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

    /**
     * Test to call gPagespeedResultReader method
     *
     * @return void
     */
    public function testCallPagespeedResultReaderForDesktop()
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

    /**
     * Test to call gPagespeedResultReader method
     *
     * @return void
     */
    public function testCallPagespeedResultReaderForMobile()
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

    /**
     * Test to call seoResultReader method
     *
     * @return void
     */
    public function testCallYslowResultReader()
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

    /**
     * Test to run seoResultReader method
     *
     * @return void
     */
    public function testRunSeoResultReader()
    {
        $json = json_encode([
            'url' => 'https://example.com/',
            'name' => 'SEO Checker',
            'checking' => [
                [
                    'error' => 'Error',
                    'desc' => 'Test description.',
                ],
            ]
        ]);
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 1)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class . '[newInstance, save]');
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andReturn(json_decode($json));
        $issue->shouldReceive('newInstance')->once()->andReturn($issue);
        $issue->shouldReceive('save')->once()->andReturn(true);

        $reader->setJob($jobFaker);
        $reader->seoResultReader('example');

        $this->seeInDatabase('job_inspects', [
            'status' => 2
        ]);
    }

    /**
     * Test to run seoResultReader method and catch exception
     *
     * @return void
     */
    public function testRunSeoResultReaderCatchException()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 1)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andThrow(new FileNotFoundException);

        $reader->setJob($jobFaker);
        $reader->seoResultReader('example.json');

        $this->seeInDatabase('job_inspects', [
            'status' => -1
        ]);
    }

    /**
     * Test to run htmlResultReader method
     *
     * @return void
     */
    public function testRunHtmlResultReader()
    {
        $json = json_encode([
            'url' => 'https://example.com/',
            'name' => 'HTML Linter',
            'checking' => [
                [
                    'type' => 'Error',
                    'desc' => 'Test description.',
                    'line' => 1
                ],
            ]
        ]);
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 3)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class . '[newInstance, save]');
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andReturn(json_decode($json));
        $issue->shouldReceive('newInstance')->once()->andReturn($issue);
        $issue->shouldReceive('save')->once()->andReturn(true);

        $reader->setJob($jobFaker);
        $reader->htmlResultReader('example');

        $this->seeInDatabase('job_inspects', [
            'status' => 2
        ]);
    }

    /**
     * Test to run htmlResultReader method and catch exception
     *
     * @return void
     */
    public function testRunHtmlResultReaderCatchException()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 3)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andThrow(new FileNotFoundException);

        $reader->setJob($jobFaker);
        $reader->htmlResultReader('example.json');

        $this->seeInDatabase('job_inspects', [
            'status' => -1
        ]);
    }

    /**
     * Test to run cssResultReader method
     *
     * @return void
     */
    public function testRunCssResultReader()
    {
        $json = json_encode([
            'url' => 'https://example.com/',
            'name' => 'Css Linter',
            'checking' => [
                [
                    'messageType' => 'Error',
                    'messageMsg' => 'Test description.',
                    'messageLine' => 1
                ],
            ]
        ]);
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 4)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class . '[newInstance, save]');
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andReturn(json_decode($json));
        $issue->shouldReceive('newInstance')->once()->andReturn($issue);
        $issue->shouldReceive('save')->once()->andReturn(true);

        $reader->setJob($jobFaker);
        $reader->cssResultReader('example');

        $this->seeInDatabase('job_inspects', [
            'status' => 2
        ]);
    }

    /**
     * Test to run cssResultReader method and catch exception
     *
     * @return void
     */
    public function testRunCssResultReaderCatchException()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 4)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andThrow(new FileNotFoundException);

        $reader->setJob($jobFaker);
        $reader->cssResultReader('example.json');

        $this->seeInDatabase('job_inspects', [
            'status' => -1
        ]);
    }

    /**
     * Test to run jsResultReader method
     *
     * @return void
     */
    public function testRunJsResultReader()
    {
        $json = json_encode([
            'url' => 'https://example.com/',
            'name' => 'Js Linter',
            'checking' => [
                [
                    'id' => 'Error',
                    'reason' => 'Test description.',
                    'line' => 1
                ],
            ]
        ]);
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 5)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class . '[newInstance, save]');
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andReturn(json_decode($json));
        $issue->shouldReceive('newInstance')->once()->andReturn($issue);
        $issue->shouldReceive('save')->once()->andReturn(true);

        $reader->setJob($jobFaker);
        $reader->jsResultReader('example');

        $this->seeInDatabase('job_inspects', [
            'status' => 2
        ]);
    }

    /**
     * Test to run jsResultReader method and catch exception
     *
     * @return void
     */
    public function testRunJsResultReaderCatchException()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 5)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andThrow(new FileNotFoundException);

        $reader->setJob($jobFaker);
        $reader->jsResultReader('example.json');

        $this->seeInDatabase('job_inspects', [
            'status' => -1
        ]);
    }

    /**
     * Test to run socialMediaResultReader method
     *
     * @return void
     */
    public function testRunSoccialMediaResultReader()
    {
        $json = json_encode([
            'url' => 'https://example.com/',
            'name' => 'Social Media Linter',
            'checking' => [
                [
                    'socmedName' => 'Open Graph',
                    'message' => [
                        [
                            'error' => 'Error',
                            'desc' => 'Test description.'
                        ]
                    ]
                ]
            ]
        ]);
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 6)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class . '[newInstance, save]');
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andReturn(json_decode($json));
        $issue->shouldReceive('newInstance')->once()->andReturn($issue);
        $issue->shouldReceive('save')->once()->andReturn(true);

        $reader->setJob($jobFaker);
        $reader->socialMediaResultReader('example');

        $this->seeInDatabase('job_inspects', [
            'status' => 2
        ]);
    }

    /**
     * Test to run socialMediaResultReader method and catch exception
     *
     * @return void
     */
    public function testRunSoccialMediaResultReaderCatchException()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 6)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andThrow(new FileNotFoundException);

        $reader->setJob($jobFaker);
        $reader->socialMediaResultReader('example.json');

        $this->seeInDatabase('job_inspects', [
            'status' => -1
        ]);
    }

    /**
     * Test to run gPagespeedResultReader method
     *
     * @return void
     */
    public function testRunPageSpeedResultReader()
    {
        $json = json_encode([
            'id' => 'https://example.com/',
            'formattedResults' => [
                'ruleResults' => [
                    [
                        'localizedRuleName' => 'Example',
                        'ruleImpact' => 10,
                        'urlBlocks' => [
                            [
                                'header' => [
                                    'format' => 'Test description.'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 8)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class . '[newInstance, save]');
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andReturn(json_decode($json));
        $issue->shouldReceive('newInstance')->once()->andReturn($issue);
        $issue->shouldReceive('save')->once()->andReturn(true);

        $reader->setJob($jobFaker);
        $reader->gPagespeedResultReader('example');

        $this->seeInDatabase('job_inspects', [
            'status' => 2
        ]);
    }

    /**
     * Test to run gPagespeedResultReader method and catch exception
     *
     * @return void
     */
    public function testRunPageSpeedResultReaderCatchException()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 8)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andThrow(new FileNotFoundException);

        $reader->setJob($jobFaker);
        $reader->gPagespeedResultReader('example.json');

        $this->seeInDatabase('job_inspects', [
            'status' => -1
        ]);
    }

    /**
     * Test to run ySlowResultReader method
     *
     * @return void
     */
    public function testRunYslowResultReader()
    {
        $json = json_encode([
            'url' => 'https://example.com/',
            'name' => 'YSlow',
            'checking' => [
                [
                    'error' => 'Error',
                    'name' => 'Test name',
                    'desc' => 'Test description.',
                    'code' => [
                        'foo',
                        'bar'
                    ]
                ],
            ]
        ]);
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 9)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class . '[newInstance, save]');
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andReturn(json_decode($json));
        $issue->shouldReceive('newInstance')->once()->andReturn($issue);
        $issue->shouldReceive('save')->once()->andReturn(true);

        $reader->setJob($jobFaker);
        $reader->ySlowResultReader('example');

        $this->seeInDatabase('job_inspects', [
            'status' => 2
        ]);
    }

    /**
     * Test to run ySlowResultReader method and catch exception
     *
     * @return void
     */
    public function testRunYslowResultReaderCatchException()
    {
        $jobFaker = factory(JobInspect::class)->create([
            'command_line' => 'nodejs --url http://example.com --destination /public/files/example/1/',
            'scope_id' => Scope::where('id', 9)->first()->id
        ]);

        $decoder = Mockery::mock(JsonDecoder::class . '[decodeFile]');
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);

        $decoder->shouldReceive('decodeFile')->andThrow(new FileNotFoundException);

        $reader->setJob($jobFaker);
        $reader->ySlowResultReader('example.json');

        $this->seeInDatabase('job_inspects', [
            'status' => -1
        ]);
    }

    /**
     * Test to get patterns for pagespeed error format
     *
     * @return void
     */
    public function testGetPatterns()
    {
        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);

        $this->assertEquals('/(.*)/', $reader->getPatterns(1));
        $this->assertEquals('/(.*)\|(.*)/', $reader->getPatterns(2));
    }

    /**
     * Test to get pagespeed error desc
     *
     * @return void
     */
    public function testGetPsiErrorDescriptionWithUrl()
    {
        $json = json_encode([
            'urlBlocks' => [
                'header' => [
                    'format' => 'Test description.'
                ],
                'urls' => [
                    [
                        'result' => [
                            'format' => '$1',
                            'args' => [
                                [
                                    'value' => 'test'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);
        $this->assertEquals("Test description.\ntest\n", $reader->getPsiErrorDescription(json_decode($json)));
    }

    /**
     * Test to get pagespeed error type
     *
     * @return void
     */
    public function testGetPagespeedErrorType()
    {
        $decoder = Mockery::mock(JsonDecoder::class);
        $issue = Mockery::mock(Issue::class);
        $reader = new ResultReader($decoder, $issue);

        $this->assertEquals('Error', $reader->getPsiErrorType(10));
        $this->assertEquals('Warning', $reader->getPsiErrorType(2));
    }
}
