<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Template;

use Contao\StringUtil;
use Contao\Template;

use function count;
use function implode;
use function in_array;
use function sprintf;
use function substr;

class ReplaceTableClassesFilter extends AbstractPreRenderFilter
{
    public function filter(Template $template): void
    {
        $cssClasses   = $template->class;
        $cssClasses   = StringUtil::trimsplit(' ', $cssClasses);
        $tableClasses = [];

        foreach ($cssClasses as $index => $cssClass) {
            if ($cssClass !== 'table' && substr($cssClass, 0, 6) !== 'table-') {
                continue;
            }

            $tableClasses[] = $cssClass;
            unset($cssClasses[$index]);
        }

        if (! count($tableClasses)) {
            return;
        }

        if (! in_array('table', $tableClasses)) {
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
