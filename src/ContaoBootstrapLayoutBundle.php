<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout;

use ContaoBootstrap\Core\DependencyInjection\ContaoBootstrapCoreExtension;
use Override;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use function assert;

final class ContaoBootstrapLayoutBundle extends Bundle
{
    #[Override]
    public function build(ContainerBuilder $container): void
    {
        $extension = $container->getExtension('contao_bootstrap');
        assert($extension instanceof ContaoBootstrapCoreExtension);
        $extension->addComponent(new ContaoBootstrapLayoutComponent());
    }
}
