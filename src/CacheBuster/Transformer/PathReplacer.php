<?php

namespace A3020\CacheBuster\Transformer;

class PathReplacer
{
    /**
     * @var CssPathTransformer
     */
    private $css;

    /**
     * @var JavaScriptPathTransformer
     */
    private $js;

    public function __construct(CssPathTransformer $css, JavaScriptPathTransformer $js)
    {
        $this->css = $css;
        $this->js = $js;
    }

    /**
     * @param string $pageContent
     *
     * @return string
     */
    public function replace($pageContent)
    {
        // Change JavaScript paths.
        $pageContent = preg_replace_callback(
            '/<script(?:.*?)src=[\'"](.*?)[\'"](?:.*?)>/im',
            function($matches) {
                return $this->js->transformTag($matches[0], $matches[1]);
            },
            $pageContent
        );

        // Change CSS paths.
        return preg_replace_callback(
            '/<link(?:.*?)href=[\'"](.*?)[\'"](?:.*?)>/im',
            function($matches) {
                return $this->css->transformTag($matches[0], $matches[1]);
            },
            $pageContent
        );
    }
}
