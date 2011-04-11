<?php

namespace Zenstruck\VersionBundle\Controller;

use Zenstruck\VersionBundle\DataCollector\VersionDataCollector;
use Symfony\Component\HttpFoundation\Response;

class VersionController
{
    protected $collector;

    public function __construct(VersionDataCollector $collector)
    {
        $this->collector = $collector;
    }


    public function showAction()
    {   
        return new Response($this->collector->getVersion());
    }
}
