<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace ContaoBootstrap\Layout\Templates;

use ContaoBootstrap\Core\Config;

/**
 * Class Modifier stores the replace css classes hook.
 *
 * @package ContaoBootstrap\Layout\Templates
 */
class Modifier
{
    /**
     * Bootstrap config.
     *
     * @var Config
     */
    private $config;

    /**
     * Modifier constructor.
     */
    public function __construct()
    {
        // TODO: Use Dependency injection.
        $this->config = \Controller::getContainer()->get('contao_bootstrap.config');
    }

    /**
     * Replace css classes.
     *
     * @param string $buffer Output buffer.
     *
     * @return string
     */
    public function replaceCssClasses($buffer)
    {
        $replaceClasses = $this->config->get('layout.replace-css-classes');

        if (empty($replaceClasses)) {
            return $buffer;
        }

        $classes = array_keys($replaceClasses);
        $classes = array_map(
            function ($class) {
                return preg_quote($class, '~');
            },
            $classes
        );

        $search = sprintf('~class="([^"]*(%s)[^"]*)"~', implode('|', $classes));

        $buffer = preg_replace_callback(
            $search,
            function ($matches) use ($replaceClasses) {
                $classes = explode(' ', $matches[1]);
                $classes = array_filter($classes);

                foreach ($classes as $index => $class) {
                    if (array_key_exists($class, $replaceClasses)) {
                        $classes[$index] = $replaceClasses[$class];
                    }
                }

                return sprintf('class="%s"', implode(' ', $classes));
            },
            $buffer
        );

        return $buffer;
    }
}
