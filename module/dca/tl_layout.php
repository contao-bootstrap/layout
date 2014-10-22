<?php

/**
 * @package   netzmacht-bootstrap
 * @author    netzmacht creative David Molineus
 * @license   MPL/2.0
 * @copyright 2013 netzmacht creative David Molineus
 */

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


$GLOBALS['TL_DCA']['tl_layout']['fields']['bootstrap_sections'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_sections'],
    'exclude'                 => true,
    'inputType'               => 'multiColumnWizard',
    'save_callback'           => array(
        array('Netzmacht\Bootstrap\Layout\Contao\DataContainer\Layout', 'autoCompleteSectionIds'),
        array('Netzmacht\Bootstrap\Layout\Contao\DataContainer\Layout', 'updateLegacySections'),
    ),
    'eval'                    => array(
        'tl_class' => 'clr long',
        'columnFields' => array(
            'label' => array(
                'label'     => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_sections_label'],
                'inputType' => 'text',
                'eval'      => array(
                    'style' => 'width: 150px',
                ),
            ),
            'id' => array(
                'label'     => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_sections_id'],
                'inputType' => 'text',
                'eval'      => array(
                    'style' => 'width: 130px',
                ),
            ),
            'template' => array(
                'label'     => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_sections_template'],
                'inputType' => 'select',
                'options_callback' => array('Netzmacht\Bootstrap\Layout\Contao\DataContainer\Layout', 'getSectionTemplates'),
                'eval'      => array(
                    'style' => 'width: 100px',
                    'includeBlankOptions' => true,
                ),
            ),
            'position' => array(
                'label'     => &$GLOBALS['TL_LANG']['tl_layout']['bootstrap_sections_position'],
                'inputType' => 'select',
                'options'   => array('top', 'before', 'after', 'bottom', 'custom'),
                'reference' => &$GLOBALS['TL_LANG']['tl_layout'],
                'eval'      => array(
                    'style' => 'width: 200px',
                    'includeblankOption' => true,
                ),
            )
        )
    ),
    'sql'                     => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['modules']['load_callback'][] = array(
    'Netzmacht\Bootstrap\Layout\Contao\DataContainer\Layout',
    'loadSectionLabels'
);