<?php

/**
 * Contao Bootstrap
 *
 * @package    contao-bootstrap
 * @subpackage Layout
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017-2018 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0-or-later
 * @filesource
 */

namespace ContaoBootstrap\Layout\View\Template;

use Contao\StringUtil;
use Contao\Template;
use Netzmacht\Html\Attributes;

/**
 * Class ReplaceImageClassesFilter.
 *
 * @package ContaoBootstrap\Layout\View\Template
 */
class ReplaceImageClassesFilter extends AbstractPreRenderFilter
{
    /**
     * {@inheritdoc}
     */
    public function filter(Template $template): void
    {
        if (empty($template->imgSize) && empty($template->picture['img'])) {
            return;
        }

        $cssClasses   = $template->class;
        $cssClasses   = StringUtil::trimsplit(' ', $cssClasses);
        $imageClasses = array();

        foreach ($cssClasses as $index => $cssClass) {
            if (substr($cssClass, 0, 4) == 'img-') {
                $imageClasses[] = $cssClass;
                unset($cssClasses[$index]);
            }

            if ($cssClass === 'rounded' || substr($cssClass, 0, 8) == 'rounded-') {
                $imageClasses[] = $cssClass;
                unset($cssClasses[$index]);
            }
        }

        if (count($imageClasses)) {
            $template->class    = implode(' ', $cssClasses);
            $template->imgSize .= sprintf(' class="%s"', $imageClasses);
            if (!empty($template->picture['img'])) {
                $picture    = $template->picture;
                $attributes = $this->parseAttributes((string) $picture['attributes']);
                $attributes->addClasses($imageClasses);

                $picture['attributes'] = (string) $attributes;

                $template->picture = $picture;
            }
        }
    }

    /**
     * Parse given attributes.
     *
     * @param string $attributeString Attributes as string.
     *
     * @return Attributes
     */
    private function parseAttributes(string $attributeString): Attributes
    {
        $attributes = new Attributes();

        array_map(
            function ($attribute) use ($attributes) {
                $attribute = trim($attribute);

                if (!$attribute) {
                    // @codingStandardsIgnoreStart
                    // phpcs thinks this return statement belongs to the method
                    return;
                    // @codingStandardsIgnoreEnd
                }

                if (preg_match('/([^=]*)="([^"]*)"/', $attribute, $matches)) {
                    $attributes->setAttribute($matches[1], $matches[2]);
                } else {
                    $attributes->setAttribute($attribute, true);
                }
            },
            explode(' ', $attributeString)
        );

        return $attributes;
    }
}
