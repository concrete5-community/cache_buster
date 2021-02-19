<?php

namespace A3020\CacheBuster\Transformer;

use Concrete\Core\Config\Repository\Repository;

abstract class PathTransformer
{
    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var string
     */
    protected $hash;

    public function __construct(Repository $config)
    {
        $this->config = $config;
        $this->hash = $this->config->get('cache_buster::settings.hash');
    }

    /**
     * @param string $tag
     * @param string $path
     *
     * @return string
     */
    public function transformTag($tag, $path)
    {
        return $this->shouldTransform($tag, $path)
            ? str_replace($path, $this->appendHash($path), $tag)
            : $tag;
    }

    /**
     * Return true if the current tag should be transformed.
     *
     * Please implement in a sub class.
     *
     * @param string $tag E.g. <script src="foo.js">
     * @param string $path E.g. foo.js
     *
     * @return bool
     */
    protected function shouldTransform($tag, $path)
    {
        return true;
    }

    /**
     * Return true if the path matches with one of the rules.
     *
     * @param string $path
     * @param array $rules
     *
     * @return bool
     */
    protected function matches($path, $rules)
    {
        foreach ($rules as $rule) {
            if (fnmatch($rule, $path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Appends the cache buster to a file name.
     *
     * If the path already contains a query string, use & instead of ?.
     *
     * @param string $path
     *
     * @return string
     */
    private function appendHash($path)
    {
        return stripos($path, '?') !== false
            ? $path . '&' . $this->hash
            : $path . '?' . $this->hash;
    }
}
