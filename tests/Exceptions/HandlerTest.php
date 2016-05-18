<?php

namespace SuitTests\Exceptions;

use Exception;
use Illuminate\Log\Writer;
use Mockery;
use Suitcoda\Exceptions\Handler;
use SuitTests\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Test Suitcoda\Exceptions\Handler
 */
class HandlerTest extends TestCase
{

    /**
     * Render HTTP Exception
     */
    public function testRenderHttpException()
    {
        $log = Mockery::mock('Illuminate\Log\Writer');
        $handler = new Handler($log);

        $exception = new HttpException('404', 'My test exception');

        $result = $handler->render('sampleRequest', $exception);

        $this->assertInstanceOf('Illuminate\Http\Response', $result);
        $this->assertEquals($exception, $result->exception);
    }

    /**
     * Render Custom Exception
     */
    public function testRenderCustomException()
    {
        $log = Mockery::mock('Illuminate\Log\Writer');
        $handler = new Handler($log);

        $exception = new Exception('My test exception', 666);

        $result = $handler->render('sampleRequest', $exception);

        $this->assertInstanceOf('Illuminate\Http\Response', $result);
        $this->assertInstanceOf('Exception', $result->exception);

        $this->assertEquals(666, $result->exception->getCode());
        $this->assertEquals('My test exception', $result->exception->getMessage());
    }

    /**
     * Report Exception
     *
     * Information:
     * We can not provide better testing for Handler::report()
     * because parent::report() do not return anything.
     * Ref: Illuminate\Foundation\Exceptions\Handler
     */
    public function testReport()
    {
        $log = Mockery::mock('Illuminate\Log\Writer');
        $handler = new Handler($log);

        $exception = new HttpException('404', 'My test exception');

        $result = $handler->report($exception);

        $this->assertEquals(null, $result);
    }

    /**
     * Report Exception
     *
     * Information:
     * We can not provide better testing for Handler::report()
     * because parent::report() do not return anything.
     * Ref: Illuminate\Foundation\Exceptions\Handler
     */
    public function testReportWithException()
    {
        $log = Mockery::mock('Illuminate\Log\Writer');
        $log->shouldReceive('error');
        $handler = new Handler($log);

        $exception = new Exception('My test exception');

        $result = $handler->report($exception);

        $this->assertEquals(null, $result);
    }
}
