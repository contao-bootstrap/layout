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
        $cssClasses   = trimsplit(' ', $cssClasses);
        $imageClasses = array();
        foreach ($cssClasses as $index => $cssClass) {
            if (substr($cssClass, 0, 4) == 'img-') {
                $imageClasses[] = $cssClass;
                unset($cssClasses[$index]);
            }
        }
        if (count($imageClasses)) {
            $imageClasses       = implode(' ', $imageClasses);
            $template->class    = implode(' ', $cssClasses);
            $template->imgSize .= sprintf(' class="%s"', $imageClasses);
            if (!empty($template->picture['img'])) {
                $picture                = $template->picture;
                $picture['attributes'] .= sprintf(' class="%s"', $imageClasses);

                $template->picture = $picture;
            }
        }
    }
}
