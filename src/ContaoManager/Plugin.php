<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use ContaoBootstrap\Core\ContaoBootstrapCoreBundle;
use ContaoBootstrap\Layout\ContaoBootstrapLayoutBundle;

final class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser): array
    {
        $bundleConfig = BundleConfig::create(ContaoBootstrapLayoutBundle::class)
            ->setLoadAfter(
                [
                    ContaoCoreBundle::class,
                    ContaoBootstrapCoreBundle::class,
                ]
            );

        return [$bundleConfig];
    }
}
