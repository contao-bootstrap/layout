<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace ContaoBootstrap\Layout\DataContainer;

use ContaoBootstrap\Core\Config;

/**
 * Dca Helper class for tl_layout.
 *
 * @package Netzmacht\Bootstrap\DataContainer
 */
class Layout
{
    /**
     * Bootstrap config.
     *
     * @var Config
     */
    private $config;

    /**
     * Layout constructor.
     */
    public function __construct()
    {
        // TODO: Dependency injection.
        $this->config = \Controller::getContainer()->get('contao_bootstrap.config');
    }

    /**
     * Set the default viewport.
     *
     * @return void
     */
    public function setDefaultViewPort()
    {
        $GLOBALS['TL_DCA']['tl_layout']['fields']['viewport']['default'] = $this->config->get('layout.viewport', '');
    }

    /**
     * Disable contao framework.
     *
     * @param \DataContainer $dataContainer Data container driver.
     *
     * @return void
     */
    public function disableFramework(\DataContainer $dataContainer)
    {
        if ($dataContainer->activeRecord->layoutType === 'bootstrap' && $dataContainer->activeRecord->framework) {
            $dataContainer->activeRecord->framework = [];
            \Database::getInstance()
                ->prepare('UPDATE tl_layout %s WHERE id=?')
                ->set(array('framework' => []))
                ->execute($dataContainer->id);
        }
    }
}
