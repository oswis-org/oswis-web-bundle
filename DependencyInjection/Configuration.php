<?php
/**
 * @noinspection ClassNameCollisionInspection
 */

namespace OswisOrg\OswisWebBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    final public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('oswis_org_oswis_web');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode->info('Default configuration for web module for OSWIS (One Simple Web IS).')->end();

        return $treeBuilder;
    }

}