<?php

/**
 * Contao Bootstrap
 *
 * @package    contao-bootstrap
 * @subpackage Layout
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Template;

use Contao\Template;
use ContaoBootstrap\Core\View\Template\Filter\PreRenderFilter;

/**
 * Class AbstractPreRenderFilter
 *
 * @package ContaoBootstrap\Layout\View\Template
 */
abstract class AbstractPreRenderFilter extends AbstractFilter implements PreRenderFilter
{
    /**
     * {@inheritdoc}
     */
    public function supports(Template $template): bool
    {
        return $this->isTemplateNameSupported($template->getName());
    }
}
