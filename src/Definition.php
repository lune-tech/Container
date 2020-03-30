<?php declare(strict_types=1);

namespace Lava\Container;

use Closure;
use InvalidArgumentException;

class Definition implements DefinitionInterface
{
    use Reflection;
    /**
     * @var string 类型
     */
    protected $concrete;

    protected $shared = false;

    protected $resolved = null;

    protected  $arguments = [];

    /**
     * @var Closure $builder
     */
    protected $builder = null;

    protected $container = null;

    function __construct($concrete)
    {
        $this->concrete = $concrete;
    }

    function setShared(bool $shared = true):DefinitionInterface
    {
        $this->shared = $shared;
        return $this;   
    }

    function isShared():bool
    {
        return $this->shared;
    }

    function getConcrete()
    {
        return $this->concrete;
    }


    /**
     * @return self
     */
    public function setArgument(string $name,$arg) : DefinitionInterface
    {
        $this->arguments[$name] = $arg;
        return $this;
    }

    /**
     * Add multiple arguments to be injected.
     *
     * @param array $args
     *
     * @return self
     */
    public function setArguments(array $args) : DefinitionInterface
    {
        $this->arguments = array_merge([],$this->arguments,$args);
        return $this;
    }
    public function setResolved($resolved) : DefinitionInterface
    {
        return $this->resolved = $resolved;
    }

    public function resolve(bool $new = false)
    {
        if($this->isShared() && !$new && !is_null($this->resolved)){
            return $this->resolved;
        }
        if(!is_null($this->builder)){
            return $this->resolved = call_user_func($this->builder,$this->getContainer(),$this->arguments,$this->concrete);
        }elseif (is_string($this->concrete)) {
            if(class_exists($this->concrete)){
                return $this->resolved = $this->invokeClass($this->concrete,$this->arguments);
            }
            throw new InvalidArgumentException(sprintf('class %s is not found ',$this->concrete));
        }else{
            return $this->resolved ?? null;
        }
    }



    public function setBuilder(Closure $builder):DefinitionInterface
    {
        $this->builder = $builder;
        return $this;
    }

    public function setContainer($container):DefinitionInterface
    {
        $this->container = $container;
        return $this;
    }



    public function getContainer()
    {
        $this->container;
    }

    public function setAlias(string ...$aliasArr)
    {
        $this->getContainer()->setAlias();
    }

    public function make($new = false)
    {
        return $this->getContainer()->resolve($this,$new);
    }
}