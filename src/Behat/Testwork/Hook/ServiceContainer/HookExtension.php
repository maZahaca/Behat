<?php

/*
 * This file is part of the Behat Testwork.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Testwork\Hook\ServiceContainer;

use Behat\Testwork\Call\ServiceContainer\CallExtension;
use Behat\Testwork\Environment\ServiceContainer\EnvironmentExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Testwork hook extension.
 *
 * Provides test hooking services for testwork.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
class HookExtension implements Extension
{
    /*
     * Available services
     */
    const DISPATCHER_ID = 'hook.dispatcher';
    const REPOSITORY_ID = 'hook.repository';

    /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return 'hooks';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadDispatcher($container);
        $this->loadRepository($container);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }

    /**
     * Loads hook dispatcher.
     *
     * @param ContainerBuilder $container
     */
    protected function loadDispatcher(ContainerBuilder $container)
    {
        $definition = new Definition('Behat\Testwork\Hook\HookDispatcher', array(
            new Reference(self::REPOSITORY_ID),
            new Reference(CallExtension::CALL_CENTER_ID)
        ));
        $container->setDefinition(self::DISPATCHER_ID, $definition);
    }

    /**
     * Loads hook repository.
     *
     * @param ContainerBuilder $container
     */
    protected function loadRepository(ContainerBuilder $container)
    {
        $definition = new Definition('Behat\Testwork\Hook\HookRepository', array(
            new Reference(EnvironmentExtension::MANAGER_ID)
        ));
        $container->setDefinition(self::REPOSITORY_ID, $definition);
    }
}
