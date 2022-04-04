<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Template;

use Contao\Template;
use ContaoBootstrap\Core\View\Template\Filter\PreRenderFilter;

abstract class AbstractPreRenderFilter extends AbstractFilter implements PreRenderFilter
{
    public function supports(Template $template): bool
    {
        return $this->isTemplateNameSupported($template->getName());
    }
}
