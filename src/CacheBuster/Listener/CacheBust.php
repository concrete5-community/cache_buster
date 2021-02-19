<?php

namespace A3020\CacheBuster\Listener;

use A3020\CacheBuster\HashGenerator;
use Concrete\Core\Config\Repository\Repository;
use Exception;
use Psr\Log\LoggerInterface;

class CacheBust
{
    /**
     * @var Repository
     */
    private $config;

    /**
     * @var HashGenerator
     */
    private $hashGenerator;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(Repository $config, HashGenerator $hashGenerator, LoggerInterface $logger)
    {
        $this->config = $config;
        $this->hashGenerator = $hashGenerator;
        $this->logger = $logger;
    }

    public function handle()
    {
        try {
           $this->config->save('cache_buster::settings.hash',
               $this->hashGenerator->generate()
           );
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
