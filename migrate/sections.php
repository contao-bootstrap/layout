<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Layout\Migrate;

class sections
{
    public function execute()
    {
        \BackendUser::getInstance();
        $database = \Database::getInstance();

        if (!$database->fieldExists('bootstrap_sections', 'tl_layout')) {
            return;
        }

        // make sure flexible sections exists
        if (!$database->fieldExists('flexible_sections', 'tl_layout')) {
            $database->query('ALTER TABLE tl_layout ADD flexible_sections blob NULL');
        }

        $query = <<<SQL
UPDATE tl_layout
SET    flexible_sections=bootstrap_sections
WHERE  bootstrap_sections != '' AND flexible_sections IS NULL
SQL;

        $database->query($query);
    }
}

$controller = new sections;
$controller->execute();
