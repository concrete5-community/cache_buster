<?php

namespace A3020\CacheBuster\Tests;

class CssMatchingTest extends MatchingCase
{
    public function testBasicCss()
    {
        $a = file_get_contents('tests/fixtures/css-01/a.html');
        $z = file_get_contents('tests/fixtures/css-01/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }

    public function testCanonicalUrl()
    {
        $a = file_get_contents('tests/fixtures/css-02/a.html');
        $z = file_get_contents('tests/fixtures/css-02/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }

    public function testMultipleTagsOnOneLine()
    {
        $a = file_get_contents('tests/fixtures/css-03/a.html');
        $z = file_get_contents('tests/fixtures/css-03/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }
}