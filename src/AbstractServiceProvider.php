<?php
declare(strict_types=1);
namespace Lava\Container;

abstract class AbstractServiceProvider implements ServiceProviderInterface
{

    protected $container;
    /**
     * {@inheritdoc}
     */
    function register()
    {}

    /**
     * {@inheritdoc}
     */    
    function boot()
    {}

    /**
     * {@inheritdoc}
     */
    function providers()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    function getContainer()
    {
        return $this->container;
    }
}