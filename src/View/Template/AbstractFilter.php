<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Template;

use ContaoBootstrap\Core\Environment;

use function is_array;
use function strcasecmp;
use function strlen;
use function substr;

abstract class AbstractFilter
{
    /**
     * Bootstrap environment.
     */
    private Environment $environment;

    /**
     * The config key for the templates.
     */
    private string $templateConfigKey;

    /**
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
     */
    protected function getEnvironment(): Environment
    {
        return $this->environment;
    }

    /**
     * Check if template name is supported.
     *
     * @param string $templateName Template name.
     */
    protected function isTemplateNameSupported(string $templateName): bool
    {
        $templateNames = $this->getEnvironment()->getConfig()->get($this->templateConfigKey);

        if (! is_array($templateNames)) {
            return false;
        }

        foreach ($templateNames as $supported) {
            if ($templateName === $supported) {
                return true;
            }

            if (
                substr($supported, -1) === '*'
                && strcasecmp(substr($supported, 0, -1), substr($templateName, 0, strlen($supported) - 1)) === 0
            ) {
                return true;
            }
        }

        return false;
    }
}
