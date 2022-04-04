<?php

/**
 * Contao Bootstrap Layout.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2018 netzmacht creative David Molineus
 * @license    LGPL 3.0-or-later
 * @filesource
 */

declare(strict_types=1);

namespace ContaoBootstrap\Layout\Listener\Hook;

use Contao\Template;
use ContaoBootstrap\Core\Environment;

/**
 * PageTemplateListener adds the bootstrap environment to the page template.
 */
final class PageTemplateListener
{
    /**
     * Bootstrap environment.
     *
     * @var Environment
     */
    private $environment;

    /**
     * PageTemplateListener constructor.
     *
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
     *
     * @return void
     */
    public function onParseTemplate(Template $template): void
    {
        if (strpos($template->getName(), 'fe_') !== 0) {
            return;
        }

        $template->bootstrapEnvironment = $this->environment;
    }
}
