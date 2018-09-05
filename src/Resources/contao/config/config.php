<?php

/**
 * Contao Bootstrap
 *
 * @package    contao-bootstrap
 * @subpackage Layout
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017-2018 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

use ContaoBootstrap\Layout\Listener\Hook\PageTemplateListener;

$GLOBALS['TL_HOOKS']['parseTemplate'][] = [PageTemplateListener::class, 'onParseTemplate'];
