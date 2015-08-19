<?php

namespace SuitTests\Model\Extension;

use Mockery;
use SuitTests\TestCase;
use Suitcoda\Model\Extension\SluggableTrait;

class SluggableTraitTest extends TestCase
{
    protected $mock;

    public function setUp()
    {
        parent::setUp();
        $this->mock = $this->getMockForTrait('Suitcoda\Model\Extension\SluggableTrait');
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testCanGetSlugField()
    {
        $this->assertEquals('slug', $this->mock->getSlugField());
    }

    public function testCanGetSeparator()
    {
        $this->assertEquals('-', $this->mock->getSeparator());
    }

    public function testCanSetAndRetrieveSlug()
    {
        $slug = 'test test';

        $this->mock->setSlug($slug);

        $this->assertEquals($this->mock->getSlug(), $slug);
    }
}
