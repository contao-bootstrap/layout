<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Template;

use function array_filter;
use function array_key_exists;
use function array_keys;
use function array_map;
use function explode;
use function implode;
use function is_array;
use function preg_quote;
use function preg_replace_callback;
use function sprintf;

final class ReplaceCssClassesFilter extends AbstractPostRenderFilter
{
    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function filter(string $buffer, string $templateName): string
    {
        $cssClasses = $this->getEnvironment()->getConfig()->get('layout.replace_css_classes');
        if (! is_array($cssClasses)) {
            return $buffer;
        }

        $classes = array_map(
            static function ($class) {
                return preg_quote($class, '~');
            },
            array_keys($cssClasses)
        );

        $search = sprintf('~class="([^"]*(%s)[^"]*)"~', implode('|', $classes));
        $buffer = preg_replace_callback(
            $search,
            static function ($matches) use ($cssClasses) {
                $classes = explode(' ', $matches[1]);
                $classes = array_filter($classes);

                foreach ($classes as $index => $class) {
                    if (! array_key_exists($class, $cssClasses)) {
                        continue;
                    }

                    $classes[$index] = $cssClasses[$class];
                }

                return sprintf('class="%s"', implode(' ', $classes));
            },
            $buffer
        );

        return $buffer;
    }
}
