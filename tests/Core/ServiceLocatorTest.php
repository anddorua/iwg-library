<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 09.10.16
 * Time: 17:49
 */

namespace Test\Core;


use PHPUnit\Framework\TestCase;

class ServiceLocatorTest extends TestCase
{

    public function testSLReturnProperClassInstance()
    {
        $config = [
            'foo' => [
                //'class' => \Test\Core\Fixture\Foo::class,
                'class' => '\Test\Core\Fixture\Foo',
                'params' => ['hello', 15],
            ],
        ];
        $sl = new \Core\ServiceLocator($config);
        $instanceName = 'foo';
        $instance = $sl->$instanceName;
        $this->assertInstanceOf(\Test\Core\Fixture\Foo::class, $instance);
    }

}