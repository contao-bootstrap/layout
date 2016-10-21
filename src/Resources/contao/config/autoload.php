<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

\TemplateLoader::addFiles(array(
        'block_section_jumbotron'           => 'system/modules/bootstrap-layout/templates',
        'block_section_jumbotron_container' => 'system/modules/bootstrap-layout/templates',
        'block_section_container'           => 'system/modules/bootstrap-layout/templates',
        'fe_bootstrap'                      => 'system/modules/bootstrap-layout/templates',
    ));

if (version_compare(VERSION, '3.3', '<')) {
    \TemplateLoader::addFile('fe_bootstrap_32', 'system/modules/bootstrap-layout/templates');
}
elseif (version_compare(VERSION, '3.4', '<')) {
    \TemplateLoader::addFile('fe_bootstrap_33', 'system/modules/bootstrap-layout/templates');
}
else {
    \TemplateLoader::addFile('fe_bootstrap_34', 'system/modules/bootstrap-layout/templates');
}
