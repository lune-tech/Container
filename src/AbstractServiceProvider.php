<?php
declare(strict_types=1);
namespace Lava\Container;

abstract class AbstractServiceProvider implements ServiceProviderInterface
{

    protected $app;
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
        $this->app = $container;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function getContainer()
    {
        return $this->container;
    }
}