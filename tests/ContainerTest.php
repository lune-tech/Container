<?php
declare(strict_types=1);
namespace Lava\Container;
use PHPUnit\Framework\TestCase;


final class ContainerTest extends TestCase
{
    function testBind()
    {
        $container = new Container();
        $container->bind('bind',function(){
            return '这是一个闭包';
        });

        $this->expectOutputString($container->get('bind'));
        $this->assertEquals($container->get('bind'),$container->get('bind'));
        print("绑定类，如果是闭包会调用闭包的值;如果是对象会");
    }

    function testInstance()
    {
        $container = new Container();
        $container->instance('instance',function(){
        });
        print("值原样返回");
        $this->expectOutputString(get_class($container->get('instance')));
    }
}
