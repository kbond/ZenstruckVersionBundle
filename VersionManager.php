<?php

namespace Zenstruck\VersionBundle;

class VersionManager
{
    protected $version;

    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            $this->version = 'File "'.$filename.'" does not exist';
            return;
        }
            
            
        $this->version = file_get_contents($filename);

    }

    public function getVersion()
    {
        return $this->version;
    }
}