<?php

/**
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2015 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

/*
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_layout']['metasubselectpalettes']['bootstrap_containerElement']['!'] = array(
    'bootstrap_containerClass'
);

/**
 * fields
 */
$GLOBALS['TL_DCA']['tl_layout']['fields']['name']['eval']['tl_class'] = 'w50';

// use template loader which shows list of safe and unsafe templates
$GLOBALS['TL_DCA']['tl_layout']['fields']['template']['reference'] = $GLOBALS['TL_LANG']['tl_layout'];
$GLOBALS['TL_DCA']['tl_layout']['fields']['template']['options_callback'] = array(
    'Netzmacht\Bootstrap\Core\Contao\DataContainer\Module',
    'getTemplates'
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['template']['eval'] = array(
    'templatePrefix' => 'fe_',
    'templateThemeId' => 'pid'
);

// do not import layout builder by default to prevent side effects
$GLOBALS['TL_DCA']['tl_layout']['fields']['framework']['default'] = array();

$GLOBALS['TL_DCA']['tl_layout']['fields']['layoutType']['save_callback'][] = array(
    'Netzmacht\Bootstrap\Layout\Contao\DataContainer\Layout',
    'disableFramework'
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_headerClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_headerClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_footerClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_footerClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_mainClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_mainClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_leftClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_leftClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_rightClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_rightClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['viewport'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['viewport'],
    'exclude'                 => true,
    'default'                 => \Netzmacht\Bootstrap\Core\Bootstrap::getConfigVar('layout.viewport', ''),
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50', 'decodeEntities' => true),
    'sql'                     => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_containerElement'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_containerElement'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('container', 'wrapper'),
    'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true, 'submitOnChange' => true),
    'sql'                     => "varchar(10) NOT NULL default 'container'"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_containerClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_containerClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(128) NOT NULL default 'container'"
);
