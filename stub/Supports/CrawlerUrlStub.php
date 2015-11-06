<?php

namespace SuitcodaStub\Supports;

use Suitcoda\Supports\CrawlerUrl;

class CrawlerUrlStub extends CrawlerUrl
{
    public function setContentTypeFlag($value)
    {
        $this->contentType = $value;
    }

    public function getContentType()
    {
        return $this->contentType;
    }
}
