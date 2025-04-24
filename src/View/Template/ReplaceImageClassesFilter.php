<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\View\Template;

use Contao\StringUtil;
use Contao\Template;
use Override;

use function count;
use function implode;
use function substr;
use function trim;

final class ReplaceImageClassesFilter extends AbstractPreRenderFilter
{
    #[Override]
    public function filter(Template $template): void
    {
        if (empty($template->imgSize) && empty($template->picture['img'])) {
            return;
        }

        $cssClasses   = $template->class;
        $cssClasses   = StringUtil::trimsplit(' ', $cssClasses);
        $imageClasses = [];

        foreach ($cssClasses as $index => $cssClass) {
            if (substr($cssClass, 0, 4) === 'img-') {
                $imageClasses[] = $cssClass;
                unset($cssClasses[$index]);
            }

            if ($cssClass !== 'rounded' && substr($cssClass, 0, 8) !== 'rounded-') {
                continue;
            }

            $imageClasses[] = $cssClass;
            unset($cssClasses[$index]);
        }

        if (! count($imageClasses)) {
            return;
        }

        $template->class = implode(' ', $cssClasses);

        if (empty($template->picture['img'])) {
            return;
        }

        $image                   = $template->picture['img'];
        $picture                 = $template->picture;
        $picture['img']['class'] = trim(($image['class'] ?? '') . ' ' . implode(' ', $imageClasses));
        $template->picture       = $picture;
    }
}
