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

use Contao\StringUtil;
use Contao\Template;

/**
 * Class ReplaceTableClassesFilter.
 *
 * @package ContaoBootstrap\Layout\View\Template
 */
class ReplaceTableClassesFilter extends AbstractPreRenderFilter
{
    /**
     * {@inheritdoc}
     */
    public function filter(Template $template): void
    {
        $cssClasses   = $template->class;
        $cssClasses   = StringUtil::trimsplit(' ', $cssClasses);
        $tableClasses = array();

        foreach ($cssClasses as $index => $cssClass) {
            if ($cssClass === 'table' || substr($cssClass, 0, 6) == 'table-') {
                $tableClasses[] = $cssClass;
                unset($cssClasses[$index]);
            }
        }

        if (count($tableClasses)) {
            if (!in_array('table', $tableClasses)) {
                $tableClasses[] = 'table';
            }
            $template->class = implode(' ', $cssClasses);
            // reset sortable, to avoid double class attributes
            if ($template->sortable) {
                $tableClasses[]     = 'sortable';
                $template->sortable = null;
            }

            $template->id = sprintf('%s" class="%s', $template->id, implode(' ', $tableClasses));
        }
    }
}
