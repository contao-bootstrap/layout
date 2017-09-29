<?php

/**
 * Contao Bootstrap Layout.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2017 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Template;

use ContaoBootstrap\Core\View\Template\Filter\PostRenderFilter;

/**
 * Class Modifier stores the replace css classes hook.
 *
 * @package ContaoBootstrap\Layout\Templates
 */
class ReplaceCssClassesFilter implements PostRenderFilter
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
     * Css class replacements.
     *
     * @var array
     */
    private $cssClasses;

    /**
     * ReplaceCssClassesModifier constructor.
     *
     * @param array $templateNames Supported template names.
     * @param array $cssClasses    Css class replacements.
     */
    public function __construct(array $templateNames, array $cssClasses)
    {
        $this->templateNames = $templateNames;
        $this->cssClasses    = $cssClasses;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $templateName): bool
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

    /**
     * {@inheritdoc}
     */
    public function filter(string $buffer, string $templateName): string
    {
        $classes = array_map(
            function ($class) {
                return preg_quote($class, '~');
            },
            array_keys($this->cssClasses)
        );

        $search = sprintf('~class="([^"]*(%s)[^"]*)"~', implode('|', $classes));
        $buffer = preg_replace_callback(
            $search,
            function ($matches) {
                $classes = explode(' ', $matches[1]);
                $classes = array_filter($classes);

                foreach ($classes as $index => $class) {
                    if (array_key_exists($class, $this->cssClasses)) {
                        $classes[$index] = $this->cssClasses[$class];
                    }
                }

                return sprintf('class="%s"', implode(' ', $classes));
            },
            $buffer
        );

        return $buffer;
    }
}
