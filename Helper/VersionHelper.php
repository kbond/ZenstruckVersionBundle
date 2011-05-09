<?php

namespace Zenstruck\Bundle\VersionBundle\Helper;

use Symfony\Component\Templating\Helper\HelperInterface;
use Zenstruck\Bundle\VersionBundle\DataCollector\VersionDataCollector;

class VersionHelper implements HelperInterface
{
    protected $collector;
    protected $charset = 'UTF-8';

    public function __construct(VersionDataCollector $collector)
    {
        $this->collector = $collector;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'version';
    }

    /**
     * Sets the default charset.
     *
     * @param string $charset The charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Gets the default charset.
     *
     * @return string The default charset
     */
    public function getCharset()
    {
        return $this->charset;
    }
    
    public function getVersion()
    {
        return $this->collector->getVersion();
    }

}
