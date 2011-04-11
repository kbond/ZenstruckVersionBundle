<?php

namespace Zenstruck\VersionBundle\Controller;

use Zenstruck\VersionBundle\VersionManager;
use Symfony\Component\HttpFoundation\Response;

class VersionController
{
    protected $versionManager;

    public function __construct(VersionManager $manager)
    {
        $this->versionManager = $manager;
    }


    public function showAction()
    {   
        return new Response($this->versionManager->getVersion());
    }
}
