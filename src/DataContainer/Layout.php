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

use Contao\DataContainer;
use ContaoBootstrap\Core\Config;
use Doctrine\DBAL\Connection;
use MultiColumnWizard;

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
     * Database connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * Layout constructor.
     *
     * @param Config     $config     Bootstrap config.
     * @param Connection $connection Database connection.
     */
    public function __construct(Config $config, Connection $connection)
    {
        $this->config     = $config;
        $this->connection = $connection;
    }

    /**
     * Get all templates. A templatePrefix can be defined using eval.templatePrefix.
     *
     * @param DataContainer $dataContainer The data container driver.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getTemplates(DataContainer $dataContainer)
    {
        $config = array();
        $prefix = '';

        // MCW compatibility
        if ($dataContainer instanceof MultiColumnWizard) {
            $field = $dataContainer->strField;
            $table = $dataContainer->strTable;
        } else {
            $field = $dataContainer->field;
            $table = $dataContainer->table;
        }

        if (array_key_exists('eval', $GLOBALS['TL_DCA'][$table]['fields'][$field])) {
            $config = $GLOBALS['TL_DCA'][$table]['fields'][$field]['eval'];
        }

        if (array_key_exists('templatePrefix', $config)) {
            $prefix = $config['templatePrefix'];
        }

        return \Controller::getTemplateGroup($prefix);
    }

    /**
     * Set the default viewport.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
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

            $statement = $this->connection->prepare('UPDATE tl_layout SET framework = \'\' WHERE id=?');
            $statement->bindValue(1, $dataContainer->id);
            $statement->execute();
        }
    }
}
