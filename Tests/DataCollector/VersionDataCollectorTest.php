<?php

namespace Zenstruck\Bundle\VersionBundle\Tests\DataCollector;

use Zenstruck\Bundle\VersionBundle\DataCollector\VersionDataCollector;

class VersionDataCollectorTest extends \PHPUnit_Framework_TestCase
{
    private $testFile;

    public function setUp()
    {
        $this->testFile = __DIR__.'/../Fixtures/VERSION';
    }

    public function testGetVersionFile()
    {
        $versionManager = new VersionDataCollector($this->testFile);

        $this->assertEquals($versionManager->getVersion(), '1.1');
    }

    public function testGetVersionFileDoesNotExist()
    {
        $versionManager = new VersionDataCollector('no_file');

        $this->assertEquals($versionManager->getVersion(), 'n/a');
    }

    public function testGetVersionPrefix()
    {
        $versionManager = new VersionDataCollector($this->testFile, '-dev');

        $this->assertEquals($versionManager->getVersion(), '1.1-dev');

        $versionManager = new VersionDataCollector('no_file', 'text');

        $this->assertEquals($versionManager->getVersion(), 'text');
    }

}
