<?php
declare(strict_types=1);
namespace Lava\Container;

use Lava\Container\exception\NotFoundException;
use SplObjectStorage;

class DefinitionAggregate
{
    protected $_defineStorage = [];
    protected $_defineAlias;
    function __construct()
    {
        $this->_defineAlias = new SplObjectStorage;
    }
    function set(string $id,DefinitionInterface $define)
    {
        $this->_defineStorage[$id] = $define;
        if(!isset($this->_defineAlias[$define])){
            $this->_defineAlias[$define] = [];
        }
        $this->_defineAlias[$define][$id] = true;
    }

    function has(string $id)
    {
        return isset($this->_defineStorage[$id]);
    }

    function get(string $id)
    {
        
        if($this->has($id)){
            return $this->_defineStorage[$id];
        }
        throw new NotFoundException($id);
    }

    function setAlias(DefinitionInterface $define,...$aliasArr)
    {
        foreach($aliasArr as $alias){
            $this->_defineAlias[$define][] =  $alias;
        }
    }
    function getAlias(DefinitionInterface $define)
    {
        if(isset($this->_defineAlias[$define])){
            return $this->_defineAlias[$define];
        }
        return [];
    }

}