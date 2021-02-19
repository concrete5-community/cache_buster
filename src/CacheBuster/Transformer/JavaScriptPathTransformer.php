<?php

namespace A3020\CacheBuster\Transformer;

final class JavaScriptPathTransformer extends PathTransformer
{
    /**
     * @inheritdoc
     */
    protected function shouldTransform($tag, $path)
    {
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
        return $this->matches($path, $this->config->get('cache_buster::settings.javascript_include', []));
    }

    private function isPathExcluded($path)
    {
        return $this->matches($path, $this->config->get('cache_buster::settings.javascript_exclude', []));
    }
}
