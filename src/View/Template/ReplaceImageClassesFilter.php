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
            if (substr($cssClass, 0, 4) === 'img-') {
                $imageClasses[] = $cssClass;
                unset($cssClasses[$index]);
            }

            if ($cssClass === 'rounded' || substr($cssClass, 0, 8) === 'rounded-') {
                $imageClasses[] = $cssClass;
                unset($cssClasses[$index]);
            }
        }

        if (count($imageClasses)) {
            $template->class = implode(' ', $cssClasses);

            if (!empty($template->picture['img'])) {
                $picture                 = $template->picture;
                $picture['img']['class'] = trim(($image['class'] ?? '') . ' ' . implode(' ', $imageClasses));
                $template->picture       = $picture;
            }
        }
    }
}
