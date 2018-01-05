<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace spec\ContaoBootstrap\Layout\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use ContaoBootstrap\Core\ContaoBootstrapCoreBundle;
use ContaoBootstrap\Layout\ContaoManager\Plugin;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PluginSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Plugin::class);
    }

    function it_is_a_bundle_plugin()
    {
        $this->shouldImplement(BundlePluginInterface::class);
    }

    function it_loads_after_contao_core(ParserInterface $parser)
    {
        $this->getBundles($parser)[0]->getLoadAfter()->shouldContain(ContaoCoreBundle::class);
    }

    function it_loads_after_bootstrap_core(ParserInterface $parser)
    {
        $this->getBundles($parser)[0]->getLoadAfter()->shouldContain(ContaoBootstrapCoreBundle::class);
    }
}
