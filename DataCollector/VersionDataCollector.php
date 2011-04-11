<?php

namespace Zenstruck\VersionBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VersionDataCollector extends DataCollector
{

    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            $this->setVersion('File "' . $filename . '" does not exist');
            return;
        }

        $this->setVersion(file_get_contents($filename));
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

    public function getName()
    {
        return 'version';
    }

}
