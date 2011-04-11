<?php

namespace Zenstruck\VersionBundle\Tests;

use Zenstruck\VersionBundle\VersionManager;

class VersionManagerTest extends \PHPUnit_Framework_TestCase
{

    private $testFile;

    public function setUp()
    {
        $this->testFile = __DIR__.'/data/VERSION';
    }

    public function testGetVersionFile()
    {
        $versionManager = new VersionManager($this->testFile);

        $this->assertEquals($versionManager->getVersion(), '1.1');
    }

    /**
     * @expectedException \Exception
     */
    public function testFileNotFound()
    {
        $versionManager = new VersionManager('/does/not/exist');
    }

}
