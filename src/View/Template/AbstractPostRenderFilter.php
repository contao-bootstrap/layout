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

use ContaoBootstrap\Core\View\Template\Filter\PostRenderFilter;

/**
 * Class AbstractPostRenderFilter
 *
 * @package ContaoBootstrap\Layout\View\Template
 */
abstract class AbstractPostRenderFilter extends AbstractFilter implements PostRenderFilter
{
    /**
     * {@inheritdoc}
     */
    public function supports(string $templateName): bool
    {
        return $this->isTemplateNameSupported($templateName);
    }
}
