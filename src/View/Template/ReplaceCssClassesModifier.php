<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Template;

use ContaoBootstrap\Core\View\Template\AbstractParseModifier;

/**
 * Class Modifier stores the replace css classes hook.
 *
 * @package ContaoBootstrap\Layout\Templates
 */
class ReplaceCssClassesModifier extends AbstractParseModifier
{
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
        parent::__construct($templateNames);

        $this->cssClasses = $cssClasses;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(string $templateName): bool
    {
        if (empty($this->cssClasses)) {
            return false;
        }

        return parent::supports($templateName);
    }

    /**
     * {@inheritdoc}
     */
    public function parse(string $buffer, string $templateName): string
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
