<?php
declare(strict_types=1);
namespace Lava\Container;

interface ServiceProviderInterface
{

    function register();

    
    function boot();

    /**
     * @return array
     */
    function providers();

    /**
     * @param Container
     * @return void
     */
    function setContainer($container);

    /**
     * @return Container
     */
    function getContainer();
}