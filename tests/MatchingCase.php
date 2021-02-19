<?php

namespace A3020\CacheBuster\Tests;

use A3020\CacheBuster\Transformer\CssPathTransformer;
use A3020\CacheBuster\Transformer\PathReplacer;
use A3020\CacheBuster\Transformer\JavaScriptPathTransformer;
use PHPUnit\Framework\TestCase;

class MatchingCase extends TestCase
{
    protected function getReplacer()
    {
        $css = new CssPathTransformer($this->getConfig());
        $js = new JavaScriptPathTransformer($this->getConfig());

        return new PathReplacer($css, $js);
    }

    private function getConfig()
    {
        $map = [
            ['cache_buster::settings.hash', null, 'abcd'],
            ['cache_buster::settings.css_include', [], []],
            ['cache_buster::settings.css_exclude', [], []],
            ['cache_buster::settings.javascript_include', [], []],
            ['cache_buster::settings.javascript_exclude', [], []],
        ];

        $configMock = $this->createMock(\Concrete\Core\Config\Repository\Repository::class);
        $configMock
            ->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($map));

        return $configMock;
    }
}
