Lava/Container
======

A fast and intuitive dependency injection container.

Installation
------------

```bash
    composer require lava/container
```

Usage
-----

创建一个容器实例

``` php
    require __DIR__."/vendor/autoload.php";
    $container = new \Lava\Container\Container();
```

快速上手

``` php
    class B{
        protected $a;
        function __construct(A $a)
        {
            $this->a = $a;
        }
    }
    class A{
    }

    // 绑定类实例
    $container->bind("a",new A);
    // 传类名 他会自动帮你实例化A类
    $container->bind("b","B");
    // 使用闭包动态构建A类
    $container->bind('a',function($container){
        return new A;
    });
    //绑定自身
    $container->bind("A");

    //绑定一个共享实例
    $container->singleton("A",function(){
        return new A;
    });

    //绑定会返回一个实例构建器 你可以通过他来写别名或者覆盖旧的构建器
    $container->bind("A")->setAlias("b")->setBuilder(function(){});
    
```

License
----------

 Apache2