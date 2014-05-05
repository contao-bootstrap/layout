<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   netzmacht-bootstrap
 * @author    netzmacht creative David Molineus
 * @license   MPL/2.0
 * @copyright 2013 netzmacht creative David Molineus
 */

namespace Netzmacht\Bootstrap\DataContainer;

use Netzmacht\Bootstrap\Core\Bootstrap;

/**
 * Class Layout
 * @package Netzmacht\Bootstrap\DataContainer
 */
class Layout extends General
{

	/**
	 * singleton
	 * @var Layout
	 */
	protected static $instance;


	/**
	 * get single instance
	 * @return Layout
	 */
	public static function getInstance()
	{
		if(static::$instance === null) {
			static::$instance = new static();
		}

		return static::$instance;
	}


	/**
	 * modify palette if bootstrap is used
	 *
	 * @hook palettes_hook (MetaPalettes)
	 */
	public function generatePalette()
	{
		// TODO: How to handle editAll actions?
		if(\Input::get('table') != 'tl_layout' || \Input::get('act') != 'edit') {
			return;
		}

		// we cannot use the model because of contao/core #6179, fixed in 3.1.3
		//$layout = \LayoutModel::findByPk(\Input::get('id'));
		$layout = \Database::getInstance()
			->prepare('SELECT * FROM tl_layout WHERE id=?')
			->execute(\Input::get('id'));

		// dynamically render palette so that extensions can plug into default palette
		if($layout->layoutType == 'bootstrap') {
			$GLOBALS['TL_DCA']['tl_layout']['metapalettes']['__base__']                 = $this->getMetaPaletteOfPalette('tl_layout');
			$GLOBALS['TL_DCA']['tl_layout']['metapalettes']['default extends __base__'] = $GLOBALS['BOOTSTRAP']['layout']['metapalette'];

			// unset default palette. otherwise metapalettes will not render this palette
			unset($GLOBALS['TL_DCA']['tl_layout']['palettes']['default']);

			$subSelectPalettes = Bootstrap::getConfigVar('layout.metasubselectpalettes', array());

			foreach($subSelectPalettes as $field => $meta) {
				foreach($meta as $value => $definition) {
					// TODO: WTH are we doing here?
					unset($GLOBALS['TL_DCA']['tl_layout']['subpalettes'][$field . '_' . $value]);
					$GLOBALS['TL_DCA']['tl_layout']['metasubselectpalettes'][$field][$value] = $definition;
				}
			}
		} else {
			\MetaPalettes::appendFields('tl_layout', 'title', array('layoutType'));
		}
	}

}