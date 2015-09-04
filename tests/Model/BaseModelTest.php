<?php

namespace SuitTests\Model;

use SuitTests\TestCase;
use Suitcoda\Model\User as Model;

class BaseModelTest extends TestCase
{
    public function testGetKeyReturnsValueOfSlug()
    {
        $model = new Model;
        $model->slug = 'test';
        $this->assertEquals('test', $model->getUrlKey());
        $this->assertEquals('slug', $model->getUrlKeyName());
    }
}
