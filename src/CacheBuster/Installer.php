<?php

namespace A3020\CacheBuster;

use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single;

class Installer implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var HashGenerator
     */
    private $hashGenerator;

    /**
     * @var Repository
     */
    private $config;

    public function __construct(HashGenerator $hashGenerator, Repository $config)
    {
        $this->hashGenerator = $hashGenerator;
        $this->config = $config;
    }

    /**
     * @param \Concrete\Core\Package\Package $pkg
     */
    public function install($pkg)
    {
        $this->configure();
        $this->dashboardPages($pkg);
    }

    private function configure()
    {
        if (!$this->config->get('cache_buster::settings.hash')) {
            $this->config->save('cache_buster::settings.hash', $this->hashGenerator->generate());
        }
    }

    private function dashboardPages($pkg)
    {
        $pages = [
            '/dashboard/system/optimization/cache_buster' => 'Cache Buster',
            '/dashboard/system/optimization/cache_buster/settings' => 'Settings',
        ];

        foreach ($pages as $path => $name) {
            /** @var Page $page */
            $page = Page::getByPath($path);
            if ($page && !$page->isError()) {
                continue;
            }

            $singlePage = Single::add($path, $pkg);
            $singlePage->update([
                'cName' => $name,
            ]);
        }
    }
}
