<?php

declare(strict_types=1);

namespace ContaoBootstrap\Layout\Listener\Dca;

use Contao\DataContainer;
use ContaoBootstrap\Core\Config;
use Doctrine\DBAL\Connection;

final class LayoutDcaListener
{
    /**
     * Bootstrap config.
     */
    private Config $config;

    /**
     * Database connection.
     */
    private Connection $connection;

    /**
     * @param Config     $config     Bootstrap config.
     * @param Connection $connection Database connection.
     */
    public function __construct(Config $config, Connection $connection)
    {
        $this->config     = $config;
        $this->connection = $connection;
    }

    /**
     * Set the default viewport.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function setDefaultViewPort(): void
    {
        $GLOBALS['TL_DCA']['tl_layout']['fields']['viewport']['default'] = $this->config->get('layout.viewport', '');
    }

    /**
     * Disable contao framework.
     *
     * @param DataContainer $dataContainer Data container driver.
     */
    public function disableFramework(DataContainer $dataContainer): void
    {
        if (! $dataContainer->activeRecord) {
            return;
        }

        if ($dataContainer->activeRecord->layoutType !== 'bootstrap' || ! $dataContainer->activeRecord->framework) {
            return;
        }

        $dataContainer->activeRecord->framework = [];

        $statement = $this->connection->prepare('UPDATE tl_layout SET framework = \'\' WHERE id=?');
        $statement->bindValue(1, $dataContainer->id);
        $statement->executeStatement();
    }
}
