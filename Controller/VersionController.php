<?php

namespace Zenstruck\VersionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class VersionController extends Controller
{
    public function showAction()
    {        
        $version = $this->get('zenstruck.version.manager')->getVersion();

        return new Response($version);
    }
}
