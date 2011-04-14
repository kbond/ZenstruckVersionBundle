<?php

namespace Zenstruck\VersionBundle\Twig\Extension;

use Zenstruck\VersionBundle\Helper\VersionHelper;

class VersionExtension extends \Twig_Extension
{

    protected $helper;

    public function __construct(VersionHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getName()
    {
        return 'version';
    }

    public function getFunctions()
    {
        return array(
            'version' => new \Twig_Function_Method($this, 'version', array('is_safe' => array('html'))),
        );
    }

    public function version()
    {
        return $this->helper->getVersion();
    }

}
