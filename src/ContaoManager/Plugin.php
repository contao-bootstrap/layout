<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ConfigPluginInterface;
use ContaoBootstrap\Core\ContaoBootstrapCoreBundle;
use ContaoBootstrap\Layout\ContaoBootstrapLayoutBundle;
use Override;
use Symfony\Component\Config\Loader\LoaderInterface;

final class Plugin implements BundlePluginInterface, ConfigPluginInterface
{
    /**
     * {@inheritDoc}
     */
    #[Override]
    public function getBundles(ParserInterface $parser): array
    {
        $bundleConfig = BundleConfig::create(ContaoBootstrapLayoutBundle::class)
            ->setLoadAfter(
                [
                    ContaoCoreBundle::class,
                    ContaoBootstrapCoreBundle::class,
                ],
            );

        return [$bundleConfig];
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function registerContainerConfiguration(LoaderInterface $loader, array $managerConfig): void
    {
        $loader->load(__DIR__ . '/../Resources/config/contao_bootstrap.yaml');
    }
}
