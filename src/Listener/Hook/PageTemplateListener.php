<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\Listener\Hook;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Template;
use ContaoBootstrap\Core\Environment;

use function strpos;

final class PageTemplateListener
{
    public function __construct(private readonly Environment $environment)
    {
    }

    #[AsHook('parseTemplate')]
    public function onParseTemplate(Template $template): void
    {
        if (strpos($template->getName(), 'fe_') !== 0) {
            return;
        }

        $template->bootstrapEnvironment = $this->environment;
    }
}
