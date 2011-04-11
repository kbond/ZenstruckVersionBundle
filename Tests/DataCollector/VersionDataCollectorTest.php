<?php

namespace Zenstruck\VersionBundle\Tests\DataCollector;

use Zenstruck\VersionBundle\DataCollector\VersionDataCollector;

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

}
