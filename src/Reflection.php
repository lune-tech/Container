<?php
declare(strict_types=1);
namespace Lava\Container;

use Closure;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

trait Reflection 
{
    function invokeClass($class,array $args =  [])
    {
        $ref = new ReflectionClass($class);
        $method = $ref->getConstructor();
        return new $class(...$this->invokeArguments(
            is_null($method)?[]:$method->getParameters(),$args
        ));
    }

    function invokeArguments(array $parameters,array $args = [])
    {
        return array_map(function(ReflectionParameter $parameter) use($args){
            if(isset($args['$'.$parameter->getName()])){
                $value =  $args['$'.$parameter->getName()];
                if($value instanceof Closure){
                    return $value($this->getContainer());
                }
                return $value;
            }elseif ($parameter->hasType() && isset($args[$parameter->getType().""])) {
                $value =  $args[$parameter->getType().""];
                if($value instanceof Closure){
                    return $value($this->getContainer());
                }
                return $value;
            } elseif($parameter->isDefaultValueAvailable()){
                return $parameter->getDefaultValue();
            }else{
                $type = $parameter->getType()."";
                switch($type){
                    case 'string':
                        return "";
                    case 'int':
                        return 0;
                    case 'float':
                        return 0.0;
                    case 'array':
                        return [];
                    case 'bool':
                        return false;
                    default:
                        if(class_exists($type)){
                            return $this->getContainer()->make($type);
                        }else{
                            return null;
                        }
                }
            }
        },$parameters);
       
    }

    abstract function getContainer();

}