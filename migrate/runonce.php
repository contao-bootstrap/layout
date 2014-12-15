<?php

namespace Netzmacht\Bootstrap\Layout\Migrate;

class runonce
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
UPDATE  tl_layout
SET     flexible_sections=bootstrap_sections
WHERE   bootstrap_sections != '' AND flexible_sections IS NULL
SQL;

        $database->query($query);
    }
}

$runonce = new runonce;
$runonce->execute();
