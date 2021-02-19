<?php

namespace A3020\CacheBuster\Listener;

use A3020\CacheBuster\Transformer\PathReplacer;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Logging\Logger;
use Concrete\Core\Page\Page;
use Exception;

class PageOutput
{
    /**
     * @var Repository
     */
    private $config;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var \A3020\CacheBuster\Transformer\PathReplacer
     */
    private $pathReplacer;

    public function __construct(Repository $config, Logger $logger, PathReplacer $pathReplacer)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->pathReplacer = $pathReplacer;
    }

    /**
     * @param \Symfony\Component\EventDispatcher\GenericEvent $event
     */
    public function handle($event)
    {
        try {
            // Cache buster is disabled.
            if ($this->config->get('cache_buster::settings.enabled', true) === false) {
                return;
            }

            if ($this->config->get('cache_buster::settings.logging_enabled', false) === true) {
                $startTime = microtime(true);
            }

            $page = Page::getCurrentPage();

            // Cache buster is disabled in /dashboard area.
            if ($this->config->get('cache_buster::settings.enabled_in_dashboard', false) === false
                && $page->isAdminArea()
            ) {
                return;
            }

            $event->setArgument('contents',
                $this->pathReplacer->replace($event->getArgument('contents'))
            );

            if ($this->config->get('cache_buster::settings.logging_enabled', false) === true) {
                $endTime = microtime(true);
                $this->logger->addInfo(t(/*i18n: name of the addon + timestamp*/'%s finished and took %s milliseconds.',
                    t('Cache Buster'),
                    round(($endTime - $startTime) *1000, 2) // milliseconds
                ));
            }
        } catch (Exception $e) {
            $this->logger->addDebug($e->getMessage());
        }
    }
}
