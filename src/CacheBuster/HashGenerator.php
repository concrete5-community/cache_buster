<?php

namespace A3020\CacheBuster;

use Concrete\Core\Config\Repository\Repository;

final class HashGenerator
{
    /**
     * @var Repository
     */
    private $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Creates a cache buster hash.
     *
     * The length of the hash can be specified via a config setting.
     * Because it's very specific it's not controllable via the dashboard.
     *
     * @return string
     */
    public function generate()
    {
        return substr(
            time(),
            0,
            $this->config->get('cache_buster::settings.hash_length', 15)
        );
    }
}
