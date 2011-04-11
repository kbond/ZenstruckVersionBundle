<?php

namespace Zenstruck\VersionBundle;

class VersionManager
{
    protected $version;

    public function __construct($filename)
    {
        if (!file_exists($filename))
            throw new \Exception('Version file set in your config does not exist.');
            
        $this->version = file_get_contents($filename);

    }

    public function getVersion()
    {
        return $this->version;
    }
}