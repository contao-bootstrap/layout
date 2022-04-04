<?php

declare(strict_types=1);

namespace spec\ContaoBootstrap\Layout\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use ContaoBootstrap\Core\ContaoBootstrapCoreBundle;
use ContaoBootstrap\Layout\ContaoManager\Plugin;
use PhpSpec\ObjectBehavior;

/** @SuppressWarnings(PHPMD.CamelCaseMethodName) */
final class PluginSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Plugin::class);
    }

    public function it_is_a_bundle_plugin(): void
    {
        $this->shouldImplement(BundlePluginInterface::class);
    }

    public function it_loads_after_contao_core(ParserInterface $parser): void
    {
        $this->getBundles($parser)[0]->getLoadAfter()->shouldContain(ContaoCoreBundle::class);
    }

    public function it_loads_after_bootstrap_core(ParserInterface $parser): void
    {
        $this->getBundles($parser)[0]->getLoadAfter()->shouldContain(ContaoBootstrapCoreBundle::class);
    }
}
