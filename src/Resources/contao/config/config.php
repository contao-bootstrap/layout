<?php

declare(strict_types=1);

use ContaoBootstrap\Layout\Listener\Hook\PageTemplateListener;

$GLOBALS['TL_HOOKS']['parseTemplate'][] = [PageTemplateListener::class, 'onParseTemplate'];
