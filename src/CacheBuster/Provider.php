<?php

namespace A3020\CacheBuster;

use A3020\CacheBuster\Listener\CacheBust;
use A3020\CacheBuster\Listener\PageOutput;
use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Logging\Logger;
use Exception;

class Provider implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function register()
    {
        try {
            $this->listeners();
        } catch (Exception $e) {
            $this->logger->addDebug($e->getMessage());
        }
    }

    private function listeners()
    {
        $this->app['director']->addListener('on_page_output', function($event) {
            /** @var PageOutput $listener */
            $listener = $this->app->make(PageOutput::class);
            $listener->handle($event);
        });

        // Trigger this event if you want to bust the cache in your own scripts.
        $this->app['director']->addListener('on_cache_bust', function() {
            /** @var CacheBust $listener */
            $listener = $this->app->make(CacheBust::class);
            $listener->handle();
        });

        // When the cache is flushed, we'll also cache bust the JS/CSS assets.
        $this->app['director']->addListener('on_cache_flush', function() {
            /** @var CacheBust $listener */
            $listener = $this->app->make(CacheBust::class);
            $listener->handle();
        });
    }
}
