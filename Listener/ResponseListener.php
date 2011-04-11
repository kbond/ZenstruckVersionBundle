<?php

namespace Zenstruck\VersionBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Zenstruck\VersionBundle\VersionManager;

class ResponseListener
{
    protected $templating;
    protected $versionManager;
    protected $position;
    protected $prefix;

    public function __construct(TwigEngine $templating, VersionManager $version, $position, $prefix)
    {
        $this->templating = $templating;
        $this->versionManager = $version;
        $this->position = $position;
        $this->prefix = $prefix;
    }

    public function onCoreResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        // do not show for profiler
        if (!$response->headers->has('X-Debug-Token')
            || '3' === substr($response->getStatusCode(), 0, 1)
            || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
            || 'html' !== $request->getRequestFormat()
        ) {
            return;
        }

        $this->injectBlock($response);
    }

    /**
     * Injects the version block into the response
     *
     * @param Response $response A Response instance
     */
    protected function injectBlock(Response $response)
    {
        if (function_exists('mb_stripos')) {
            $posrFunction = 'mb_strripos';
            $substrFunction = 'mb_substr';
        } else {
            $posrFunction = 'strripos';
            $substrFunction = 'substr';
        }

        $content = $response->getContent();

        if (false !== $pos = $posrFunction($content, '</body>')) {
            $toolbar = "\n" . str_replace("\n", '', $this->templating->render(
                                    'ZenstruckVersionBundle:Version:block.html.twig', array(
                                        'versionManager' => $this->versionManager,
                                        'position' => $this->position,
                                        'prefix' => $this->prefix
                    ))) . "\n";
            $content = $substrFunction($content, 0, $pos) . $toolbar . $substrFunction($content, $pos);
            $response->setContent($content);
        }
    }

}
