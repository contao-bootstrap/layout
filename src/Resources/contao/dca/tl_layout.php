<?php

/**
 * Contao Bootstrap Layout.
 *
 * @package    contao-bootstrap
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014-2017 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 */

/*
 * Config
 */

$GLOBALS['TL_DCA']['tl_layout']['config']['onload_callback'][] = [
    'contao_bootstrap.layout.listener.layout_dca',
    'setDefaultViewport'
];

$GLOBALS['TL_DCA']['tl_layout']['config']['onsubmit_callback'][] = [
    'contao_bootstrap.layout.listener.layout_dca',
    'disableFramework'
];

/*
 * Palettes
 */

$GLOBALS['TL_DCA']['tl_layout']['metasubselectpalettes']['bs_containerElement']['!'] = array(
    'bs_containerClass'
);

/*
 * fields
 */

$GLOBALS['TL_DCA']['tl_layout']['fields']['name']['eval']['tl_class'] = 'w50';

$GLOBALS['TL_DCA']['tl_layout']['fields']['template']['eval'] = array(
    'templatePrefix'  => 'fe_',
    'templateThemeId' => 'pid'
);

// do not import layout builder by default to prevent side effects
$GLOBALS['TL_DCA']['tl_layout']['fields']['framework']['default'] = array();

$GLOBALS['TL_DCA']['tl_layout']['fields']['bs_headerClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bs_headerClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bs_footerClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bs_footerClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bs_mainClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bs_mainClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bs_leftClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bs_leftClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bs_rightClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bs_rightClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(150) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['viewport'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['viewport'],
    'exclude'                 => true,
    'default'                 => '',
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50', 'decodeEntities' => true),
    'sql'                     => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bs_containerElement'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bs_containerElement'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array('container', 'wrapper'),
    'eval'                    => array('tl_class' => 'w50', 'includeBlankOption' => true, 'submitOnChange' => true),
    'sql'                     => "varchar(10) NOT NULL default 'container'"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['bs_containerClass'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bs_containerClass'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('tl_class' => 'w50'),
    'sql'                     => "varchar(128) NOT NULL default 'container'"
);
