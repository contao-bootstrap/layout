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

namespace ContaoBootstrap\Layout\View\Template;

use ContaoBootstrap\Core\Environment;

/**
 * Class AbstractFilter
 *
 * @package ContaoBootstrap\Layout\View\Template
 */
abstract class AbstractFilter
{
    /**
     * Bootstrap environment.
     *
     * @var Environment
     */
    private $environment;

    /**
     * The config key for the templates.
     *
     * @var string
     */
    private $templateConfigKey;

    /**
     * AbstractFilter constructor.
     *
     * @param Environment $environment       The bootstrap environment.
     * @param string      $templateConfigKey The templates config key.
     */
    public function __construct(Environment $environment, string $templateConfigKey)
    {
        $this->environment       = $environment;
        $this->templateConfigKey = $templateConfigKey;
    }

    /**
     * Get environment.
     *
     * @return Environment
     */
    protected function getEnvironment(): Environment
    {
        return $this->environment;
    }

    /**
     * Check if template name is supported.
     *
     * @param string $templateName Template name.
     *
     * @return bool
     */
    protected function isTemplateNameSupported(string $templateName): bool
    {
        $templateNames = $this->getEnvironment()->getConfig()->get($this->templateConfigKey);

        if (!is_array($templateNames)) {
            return false;
        }

        foreach ($templateNames as $supported) {
            if ($templateName === $supported) {
                return true;
            }

            if (substr($supported, -1) === '*'
                && 0 == strcasecmp(substr($supported, 0, -1), substr($templateName, 0, (strlen($supported) - 1)))
            ) {
                return true;
            }
        }

        return false;
    }
}
