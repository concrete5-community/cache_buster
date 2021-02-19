<?php

namespace A3020\CacheBuster\Transformer;

final class CssPathTransformer extends PathTransformer
{
    /**
     * @inheritdoc
     */
    protected function shouldTransform($tag, $path)
    {
        if (stripos($tag, 'rel="stylesheet"') === false
            && stripos($tag, "rel='stylesheet'") === false
        ) {
            // This is not a CSS link, but e.g. a canonical link.
            return false;
        }

        if ($this->isPathIncluded($path)) {
            return true;
        }

        if ($this->isPathExcluded($path)) {
            return false;
        }

        return true;
    }

    private function isPathIncluded($path)
    {
        return $this->matches($path, $this->config->get('cache_buster::settings.css_include', []));
    }

    private function isPathExcluded($path)
    {
        return $this->matches($path, $this->config->get('cache_buster::settings.css_exclude', []));
    }
}
