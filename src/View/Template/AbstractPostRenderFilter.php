<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Template;

use ContaoBootstrap\Core\View\Template\Filter\PostRenderFilter;
use Override;

abstract class AbstractPostRenderFilter extends AbstractFilter implements PostRenderFilter
{
    #[Override]
    public function supports(string $templateName): bool
    {
        return $this->isTemplateNameSupported($templateName);
    }
}
