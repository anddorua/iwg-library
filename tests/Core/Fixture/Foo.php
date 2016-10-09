<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.10.16
 * Time: 17:51
 */

namespace Test\Core\Fixture;


class Foo
{

    /**
     * Foo constructor.
     * @param $a mixed
     * @param $b mixed
     * @throws \Exception
     */
    public function __construct($a, $b)
    {
        if (!(isset($a) && isset($b))) {
            throw new \Exception("too few parameters to Foo constructor");
        }
    }
}