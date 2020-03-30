<?php
declare(strict_types=1);
namespace Lava\Container;

use Closure;

interface DefinitionInterface
{

    public function setShared(bool $shared) : DefinitionInterface;

    /**
     * Is this a shared definition?
     *
     * @return boolean
     */
    public function isShared() : bool;

    /**
     * Get the concrete of the definition.
     *
     * @return mixed
     */
    public function getConcrete();

    /**
     * Add an argument to be injected.
     *
     * @param mixed $arg
     *
     * @return self
     */
    public function setArgument(string $name,$arg) : DefinitionInterface;

    /**
     * Add multiple arguments to be injected.
     *
     * @param array $args
     *
     * @return self
     */
    public function setArguments(array $args) : DefinitionInterface;

    /**
     * Handle instantiation and manipulation of value and return.
     *
     * @param boolean $new
     *
     * @return mixed
     */
    public function resolve(bool $new = false);

    public function setBuilder(Closure $builder) : DefinitionInterface;


    public function setContainer($container) : DefinitionInterface;

    public function getContainer();

    public function setResolved($resolved) : DefinitionInterface;

    public function setAlias(string ...$alias);

    
}