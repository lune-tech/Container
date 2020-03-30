<?php
declare(strict_types=1);
namespace Lava\Container;

use Generator;

class ServiceProviderAggregate
{



    protected $_registerd = [];

    protected $booted = [];

    protected $_container = null;


    function getIterator():Generator
    {
        foreach($this->_registerd as $service){
            yield $service;
        }
    }


    function boot(string $id)
    {
        foreach ($this->getIterator() as $service) {
            if(in_array($id,$service->providers(),true) && !in_array($service,$this->booted,true)){
                $service->boot();
                $this->booted[] =  $service;
            }
        }
    }

    /**
     * @param ServiceProviderInterface $service
     * @return bool
     */
    function register(ServiceProviderInterface $service)
    {
        $class = get_class($service);
        if(isset($this->_registerd[$class])){
            return false;
        }

        $service->setContainer($this->getContainer())->register();

        $this->_registerd[$class] = $service;

        return true;
    }

    function setContainer($container)
    {
        $this->_container = $container;
    }

    function getContainer()
    {
        return $this->_container;
    }
}