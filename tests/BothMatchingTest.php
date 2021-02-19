<?php

namespace A3020\CacheBuster\Tests;

class BothMatchingTest extends MatchingCase
{
    public function testFullPage()
    {
        $a = file_get_contents('tests/fixtures/both-01/a.html');
        $z = file_get_contents('tests/fixtures/both-01/z.html');

        $this->assertEquals(
            $z,
            $this->getReplacer()->replace($a)
        );
    }
}