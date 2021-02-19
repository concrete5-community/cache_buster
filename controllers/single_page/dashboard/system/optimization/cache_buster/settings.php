<?php

namespace Concrete\Package\CacheBuster\Controller\SinglePage\Dashboard\System\Optimization\CacheBuster;

use A3020\CacheBuster\HashGenerator;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

final class Settings extends DashboardPageController
{
    public function view()
    {
        $config = $this->app->make(Repository::class);

        $this->set('enableCacheBuster', $config->get('cache_buster::settings.enabled', true));
        $this->set('enableInDashboardArea', $config->get('cache_buster::settings.enabled_in_dashboard', false));
        $this->set('enableLogging', $config->get('cache_buster::settings.logging_enabled', false));
        $this->set('hash', $config->get('cache_buster::settings.hash'));
        $this->set('lastBusted', $this->getLastBusted($config->get('cache_buster::settings.hash')));

        $this->set('cssInclude', implode("\n", $config->get('cache_buster::settings.css_include', [])));
        $this->set('cssExclude', implode("\n", $config->get('cache_buster::settings.css_exclude', [])));
        $this->set('javaScriptInclude', implode("\n", $config->get('cache_buster::settings.javascript_include', [])));
        $this->set('javaScriptExclude', implode("\n", $config->get('cache_buster::settings.javascript_exclude', [])));
    }

    public function save()
    {
        if (!$this->token->validate('a3020.cache_buster.settings')) {
            $this->flash('error', $this->token->getErrorMessage());

            return Redirect::to('/dashboard/system/optimization/cache_buster/settings');
        }

        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $config->save('cache_buster::settings.enabled', (bool) $this->post('enableCacheBuster'));
        $config->save('cache_buster::settings.enabled_in_dashboard', (bool) $this->post('enableInDashboardArea'));
        $config->save('cache_buster::settings.logging_enabled', (bool) $this->post('enableLogging'));

        $config->save('cache_buster::settings.css_include', $this->convertToArray($this->post('cssInclude')));
        $config->save('cache_buster::settings.css_exclude', $this->convertToArray($this->post('cssExclude')));
        $config->save('cache_buster::settings.javascript_include', $this->convertToArray($this->post('javaScriptInclude')));
        $config->save('cache_buster::settings.javascript_exclude', $this->convertToArray($this->post('javaScriptExclude')));

        $this->flash('success', t('Your settings have been saved.'));

        return Redirect::to('/dashboard/system/optimization/cache_buster/settings');
    }

    public function bust()
    {
        /** @var HashGenerator $hashGenerator */
        $hashGenerator = $this->app->make(HashGenerator::class);

        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $config->save('cache_buster::settings.hash', $hashGenerator->generate());

        $this->flash('success',
            t('Done! CSS and JavaScript assets will now be reloaded by the browser.')
        );

        return Redirect::to('/dashboard/system/optimization/cache_buster/settings');
    }

    /**
     * @param string $data
     *
     * @return array
     */
    private function convertToArray($data)
    {
        return array_filter(
            array_map('trim',
                explode("\n", str_replace("\r", '', $data))
            )
        );
    }

    /**
     * Returns a localized date + time of when the cache was busted for the last time.
     *
     * @param string $timestamp
     *
     * @return string|null
     */
    private function getLastBusted($timestamp)
    {
        if (!trim($timestamp)) {
            return null;
        }

        /** @var \Concrete\Core\Localization\Service\Date $dh */
        $dh = $this->app->make('helper/date');

        return $dh->date('d F Y, H:i:s', $timestamp);
    }
}
