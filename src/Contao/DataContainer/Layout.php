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

namespace Netzmacht\Bootstrap\Layout\Contao\DataContainer;

use Netzmacht\Bootstrap\Core\Bootstrap;

/**
 * Class Layout
 * @package Netzmacht\Bootstrap\DataContainer
 */
class Layout
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

		$layout = \LayoutModel::findByPk(\Input::get('id'));

		// dynamically render palette so that extensions can plug into default palette
		if($layout->layoutType == 'bootstrap') {
			$metaPalettes                             = & $GLOBALS['TL_DCA']['tl_layout']['metapalettes'];
			$metaPalettes['__base__']                 = $this->getMetaPaletteOfPalette('tl_layout');
			$metaPalettes['default extends __base__'] = Bootstrap::getConfigVar('layout.metapalette', array());

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


	/**
	 * Creates an meta palette of a palettes
	 *
	 * @param string $table
	 * @param string $name
	 * @return array
	 */
	protected function getMetaPaletteOfPalette($table, $name = 'default')
	{
		$palette     = $GLOBALS['TL_DCA'][$table]['palettes'][$name];
		$metaPalette = array();
		$legends     = explode(';', $palette);

		foreach($legends as $legend) {
			$fields = explode(',', $legend);

			preg_match('/\{(.*)_legend(:hide)?\}/', $fields[0], $matches);

			if(isset($matches[2])) {
				$fields[0] = $matches[2];
			} else {
				array_shift($fields);
			}

			$metaPalette[$matches[1]] = $fields;
		}

		return $metaPalette;
	}


	/**
	 * Get all templates for the sections block
	 * @return array
	 */
	public function getSectionTemplates()
	{
		return \Controller::getTemplateGroup('block_');
	}


	/**
	 * Load section values as language var
	 *
	 * @param $value
	 * @param $dc
	 * @return mixed
	 */
	public function loadSectionLabels($value, $dc)
	{
		$sections = deserialize($dc->activeRecord->bootstrap_sections, true);

		foreach($sections as $section) {
			if(!isset($GLOBALS['TL_LANG']['tl_article'][$section['id']])) {
				$GLOBALS['TL_LANG']['tl_article'][$section['id']] = $section['label'] ?: $section['id'];
			}
		}

		return $value;
	}


	/**
	 * Store sections in legacy section column
	 *
	 * @param $value
	 * @param $dc
	 * @return mixed
	 */
	public function updateLegacySections($value, $dc)
	{
		$sections = array();
		$value    = deserialize($value, true);

		foreach($value as $section) {
			if($section['id']) {
				$sections[] = $section['id'];
			}
		}

		$sections                   = implode(',', $sections);
		$dc->activeRecord->sections = $sections;

		\Database::getInstance()
			->prepare('UPDATE tl_layout %s WHERE id=?')
			->set(array('sections' => $sections))
			->execute($dc->id);

		return $value;
	}

}