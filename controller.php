<?php

namespace Concrete\Package\CacheBuster;

use A3020\CacheBuster\Console\Command\CacheBuster;
use A3020\CacheBuster\Installer;
use Concrete\Core\Package\Package;
use Concrete\Core\Support\Facade\Package as PackageFacade;
use A3020\CacheBuster\Provider;

final class Controller extends Package
{
    protected $pkgHandle = 'cache_buster';
    protected $appVersionRequired = '8.3.1';
    protected $pkgVersion = '1.1.0';
    protected $pkgAutoloaderRegistries = [
        'src/CacheBuster' => '\A3020\CacheBuster',
    ];

    public function getPackageName()
    {
        return t('Cache Buster');
    }

    public function getPackageDescription()
    {
        return t('Makes sure your CSS and JavaScript files are reloaded.');
    }

    public function on_start()
    {
        if ($this->app->isRunThroughCommandLineInterface()) {
            $console = $this->app->make('console');
            $console->add(new CacheBuster());
        }

        /** @var Provider $provider */
        $provider = $this->app->make(Provider::class);
        $provider->register();
    }

    public function install()
    {
        $pkg = parent::install();

        /** @var Installer $installer */
        $installer = $this->app->make(Installer::class);
        $installer->install($pkg);
    }

    public function upgrade()
    {
        parent::upgrade();

        /** @see \Concrete\Core\Package\PackageService */
        $pkg = PackageFacade::getByHandle($this->pkgHandle);

        /** @var Installer $installer */
        $installer = $this->app->make(Installer::class);
        $installer->install($pkg);
    }
}
