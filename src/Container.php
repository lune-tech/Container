<?php declare(strict_types=1);

namespace Lava\Container;

use Closure;
use InvalidArgumentException;
use SplObjectStorage;
use Psr\Container\ContainerInterface;
class Container implements ContainerInterface
{

    use Reflection;
    /**
     * @var DefinitionAggregate
     */
    protected $_definitionAggregate;

    /**
     * @var ServiceProviderAggregate
     */
    protected $_serviceProviderAggregate;

    function __construct()
    {
        $this->_definitionAggregate = new DefinitionAggregate;
        $this->_serviceProviderAggregate = new ServiceProviderAggregate;
        $this->_serviceProviderAggregate->setContainer($this);
    }

    /**
     * @param string $id
     * @param DefinitionInterface $value
     * @return DefinitionInterface
     */
    function set(string $id,DefinitionInterface $define)
    {
        $this->_definitionAggregate->set($id,$define);
        return $define;
    }



    function get($id,bool $new = false)
    {
        return $this->resolve($this->_definitionAggregate->get($id),$new);
    }


    function has($id)
    {
        return $this->_definitionAggregate->has($id);
    }

    function setAlias(DefinitionInterface $define,...$aliasArr)
    {
        return $this->_definitionAggregate->setAlias($define,...$aliasArr);
    }

    /**
     * @param string 
     * @param Closure
     */
    function singleton(string $id,Closure $concrete)
    {
        $define = new Definition($id);
        $define->setBuilder($concrete)->setShared(false);
        return $this->set($id,$define);
    }

    /**
     * @param string $id
     * @param string|DefinitionInterface|Closure|object|null $concrete
     */
    function bind(string $id,$concrete = null)
    {
        if(is_string($concrete)){
            $define = (new Definition($concrete))->setShared(true)
            ->setContainer($this);
        }elseif($concrete instanceof DefinitionInterface){
            $define = $concrete->setContainer($this);
        } elseif($concrete instanceof Closure) {
            $define =  (new Definition($id))->setContainer($this)->setBuilder($concrete)->setShared(false);
        } elseif(is_null($concrete)){
            $define = (new Definition($id))->setContainer($this)->setShared(true);
        } elseif(is_object($concrete)){
            $define = (new Definition(get_class($concrete)))->setContainer($this)->setShared(false);
        }else{
            throw new InvalidArgumentException("parameter is incorrect");
        }
        return $this->set($id,$define);
    }

    function instance(string $id,$object)
    {
       $define =  (new Definition($object))->setContainer($this)->setBuilder(function() use($object){
           return $object;
       })->setShared(false);
       return $this->set($id,$define);
    }

    function resolve(DefinitionInterface $define,$new = false)
    {
        $object = $define->resolve($new);
        foreach($this->_definitionAggregate->getAlias($define) as $alias){
            $this->_serviceProviderAggregate->boot($alias);
        }
        return $object;
    }

    /**
     * @param string|ServiceProviderInterface
     */
    function register($service)
    {
        if(is_string($service)){
            $service = new $service;
        }
        $this->_serviceProviderAggregate->register($service);
    }

    function getContainer()
    {
        return $this;
    }
}