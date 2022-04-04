<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\Listener\Hook;

use Contao\Template;
use ContaoBootstrap\Core\Environment;

use function strpos;

final class PageTemplateListener
{
    /**
     * Bootstrap environment.
     */
    private Environment $environment;

    /**
     * @param Environment $environment Bootstrap environment.
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Handle the parse template hook.
     *
     * @param Template $template The template being parsed.
     */
    public function onParseTemplate(Template $template): void
    {
        if (strpos($template->getName(), 'fe_') !== 0) {
            return;
        }

        $template->bootstrapEnvironment = $this->environment;
    }
}
