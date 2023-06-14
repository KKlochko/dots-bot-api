<?php

namespace App\DotsAPI\API\v2;

use App\DotsAPI\Fetcher\v2\ApiFetcher;

abstract class AbstractItemAPI
{
    protected ApiFetcher $fetcher;

    public function __construct(ApiFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    abstract public function getMap($context = null);

    abstract public function saveMap($map);
}

