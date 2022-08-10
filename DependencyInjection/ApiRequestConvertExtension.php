<?php

namespace tandrewcl\ApiRequestConvertBundle\DependencyInjection;

use Symfony\Component\{
    DependencyInjection\ContainerBuilder, DependencyInjection\Loader\YamlFileLoader, Config\FileLocator,
    HttpKernel\DependencyInjection\Extension
};

class ApiRequestConvertExtension extends Extension
{
    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}
