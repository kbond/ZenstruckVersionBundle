<?php

namespace Zenstruck\VersionBundle\Controller;

use Zenstruck\VersionBundle\DataCollector\VersionDataCollector;
use Symfony\Component\HttpFoundation\Response;

class VersionController
{
    protected $collector;
    protected $templating;

    public function __construct($templating, VersionDataCollector $collector)
    {
        $this->collector = $collector;
        $this->templating = $templating;
    }

    public function rawAction()
    {
        return new Response($this->collector);
    }

    public function showAction()
    {
        return $this->templating->renderResponse('ZenstruckVersionBundle:Version:show.html.twig',
            array(
                'collector' => $this->collector
            ));
    }
}
