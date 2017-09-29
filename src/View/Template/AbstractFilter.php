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

/**
 * Class AbstractFilter
 *
 * @package ContaoBootstrap\Layout\View\Template
 */
abstract class AbstractFilter
{
    /**
     * List of supported template names.
     *
     * It's allowed to wildcard a template name pattern, e.g. fe_*.
     *
     * @var array
     */
    private $templateNames = [];

    /**
     * AbstractFilter constructor.
     *
     * @param array $templateNames List of templates name patterns.
     */
    public function __construct(array $templateNames)
    {
        $this->templateNames = $templateNames;
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
        foreach ($this->templateNames as $supported) {
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
