<?php

namespace OswisOrg\OswisWebBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class OswisOrgOswisWebExtension extends Extension implements PrependExtensionInterface
{
    /**
     * This work-around allows overriding of other bundles templates OswisCore.
     *
     * @param ContainerBuilder $container
     * @param array            $bundleNames
     */
    final public static function prependForBundleTemplatesOverride(ContainerBuilder $container, array $bundleNames): void
    {
        $twigConfigs = $container->getExtensionConfig('twig');
        $paths = [];
        foreach ($twigConfigs as $twigConfig) {
            if (isset($twigConfig['paths'])) {
                $paths += $twigConfig['paths'];
            }
        }
        foreach ($bundleNames as $bundleName) {
            $paths['templates/bundles/'.$bundleName.'Bundle/'] = $bundleName;
            $paths[dirname(__DIR__).'/Resources/views/bundles/'.$bundleName.'Bundle/'] = $bundleName;
        }
        $container->prependExtensionConfig('twig', ['paths' => $paths]);
    }

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
        self::prependForBundleTemplatesOverride($container, ['OswisOrgOswisCore']);
    }
}
