<?php

namespace Zenstruck\Bundle\VersionBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;

class VersionDataCollector extends DataCollector
{

    public function __construct($filename = null, $suffix = null)
    {
        if (!file_exists($filename) && !$suffix) {
            $this->setVersion('n/a');
            return;
        }

        $version = '';

        if (file_exists($filename))
            $version .= file_get_contents($filename);

        $this->setVersion($version.$suffix);
    }

    public function  __toString()
    {
        return $this->data['version'];
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        // do nothing
    }

    protected function setVersion($version)
    {
        $this->data['version'] = $version;
    }

    public function getVersion()
    {
        return $this->data['version'];
    }

    public function getSymfony()
    {
        return Kernel::VERSION;
    }

    public function getName()
    {
        return 'version';
    }

}
