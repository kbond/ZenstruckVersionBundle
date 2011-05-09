<?php

namespace Zenstruck\Bundle\VersionBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VersionDataCollector extends DataCollector
{

    public function __construct($filename = null, $text = null)
    {   
        if (!file_exists($filename) && !$text) {
            $this->setVersion('n/a');
            return;
        }        
        
        $version = '';
        
        if (file_exists($filename))
            $version .= file_get_contents($filename);
        
        $this->setVersion($version.$text);
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

    public function getName()
    {
        return 'version';
    }

}
