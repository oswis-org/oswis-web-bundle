<?php

namespace OswisOrg\OswisWebBundle\DependencyInjection;

use Exception;
use OswisOrg\OswisCoreBundle\DependencyInjection\OswisOrgOswisCoreExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class OswisOrgOswisWebExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    final public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
        // $configuration = $this->getConfiguration($configs, $container);
        // $config = $configuration ? $this->processConfiguration($configuration, $configs) : [];
    }

    final public function prepend(ContainerBuilder $container): void
    {
        OswisOrgOswisCoreExtension::prependForBundleTemplatesOverride($container, ['OswisOrgOswisCore']);
    }
}
