<?php

namespace Zenstruck\Bundle\VersionBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZenstruckVersionBundle extends Bundle
{
    /**
     * @static
     * @param string $version
     * @return string
     */
    public static function getSymfonyVersion($version)
    {
        return implode('.', array_slice(array_map(function($val)
        {
            return (int)$val;
        }, explode('.', $version)), 0, 3));
    }
}
