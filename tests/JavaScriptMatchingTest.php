<?php

namespace A3020\CacheBuster\Tests;

class JavaScriptMatchingTest extends MatchingCase
{
    public function testBasicJavaScriptTest()
    {
        $a = file_get_contents('tests/fixtures/js-01/a.html');
        $z = file_get_contents('tests/fixtures/js-01/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }

    public function testSingleQuotesTest()
    {
        $a = file_get_contents('tests/fixtures/js-02/a.html');
        $z = file_get_contents('tests/fixtures/js-02/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }

    public function testScriptWithParameters()
    {
        $a = file_get_contents('tests/fixtures/js-03/a.html');
        $z = file_get_contents('tests/fixtures/js-03/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }

    public function testShortScriptTag()
    {
        $a = file_get_contents('tests/fixtures/js-04/a.html');
        $z = file_get_contents('tests/fixtures/js-04/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }

    public function testMultipleScriptTagsOnSameLine()
    {
        $a = file_get_contents('tests/fixtures/js-05/a.html');
        $z = file_get_contents('tests/fixtures/js-05/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }

    public function testCaptitalizedScript()
    {
        $a = file_get_contents('tests/fixtures/js-06/a.html');
        $z = file_get_contents('tests/fixtures/js-06/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }

    public function testScriptWithoutExtension()
    {
        $a = file_get_contents('tests/fixtures/js-07/a.html');
        $z = file_get_contents('tests/fixtures/js-07/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }
}