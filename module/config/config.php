<?php

/**
 * @package   netzmacht-columnset
 * @author    David Molineus <http://www.netzmacht.de>
 * @license   GNU/LGPL
 * @copyright Copyright 2012 David Molineus netzmacht creative
 *
 **/

// we do not remove the viewport setting, but make it able to modify it in the backend
// this is the default value used
$GLOBALS['BOOTSTRAP']['layout']['viewport'] = 'width=device-width, initial-scale=1.0';


// customize default palette. we remove the stuff we do not want to
// Using this way it is possible for other extensions to plug in the default palette
// MetaPalettes extending feature can be used
$GLOBALS['BOOTSTRAP']['layout']['metapalette']['-sections'][] = 'sections';
$GLOBALS['BOOTSTRAP']['layout']['metapalette']['-sections'][] = 'sPosition';
$GLOBALS['BOOTSTRAP']['layout']['metapalette']['+sections'][] = 'bootstrap_sections';
$GLOBALS['BOOTSTRAP']['layout']['metapalette']['-style'][]    = 'framework';
$GLOBALS['BOOTSTRAP']['layout']['metapalette']['-static'][]   = 'static';

if(version_compare(VERSION, '3.3', '<')) {
	$GLOBALS['BOOTSTRAP']['layout']['metapalette']['+expert'][] = 'viewport after cssClass';
}

// modification of the default subpalettes by using metasubselectpalettes
$GLOBALS['BOOTSTRAP']['layout']['metasubselectpalettes'] = array(
	'rows' => array(
		'2rwh' => array('bootstrap_headerClass'),
		'2rwf' => array('bootstrap_footerClass'),
		'3rw'  => array('bootstrap_headerClass', 'bootstrap_footerClass'),
	),

	'cols' => array(
		'1cl'  => array(),
		'2cll' => array('bootstrap_leftClass', 'bootstrap_mainClass'),
		'2clr' => array('bootstrap_mainClass', 'bootstrap_rightClass'),
		'3cl'  => array('bootstrap_leftClass', 'bootstrap_mainClass', 'bootstrap_rightClass'),
	),
);


// rewrite css classes
$GLOBALS['BOOTSTRAP']['layout']['rewrite-css-classes']['invisible']   = 'sr-only';
$GLOBALS['BOOTSTRAP']['layout']['rewrite-css-classes']['float_left']  = 'pull-left';
$GLOBALS['BOOTSTRAP']['layout']['rewrite-css-classes']['float_right'] = 'pull-right';

// replace image css classes
$GLOBALS['BOOTSTRAP']['templates']['modifiers']['callback.replaceImageClasses'] = array
(
	'type'      => 'callback',
	'callback'  => array('Netzmacht\Bootstrap\Layout\Contao\Hooks', 'replaceImageClasses'),
	'templates' => 'ce_*',
);

// replace image css classes
$GLOBALS['BOOTSTRAP']['templates']['modifiers']['callback.replaceTableClasses'] = array
(
	'type'      => 'callback',
	'callback'  => array('Netzmacht\Bootstrap\Layout\Contao\Hooks', 'replaceTableClasses'),
	'templates' => 'ce_table',
);

// replace css classes
$GLOBALS['BOOTSTRAP']['templates']['parsers']['callback.replaceClasses'] = array
(
	'type'      => 'callback',
	'callback'  => array('Netzmacht\Bootstrap\Layout\Contao\Hooks', 'replaceCssClasses'),
	'templates' => 'fe_*',
);