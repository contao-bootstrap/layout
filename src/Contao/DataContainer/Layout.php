<?php

/**
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
	 * Get all templates for the sections block
	 * @return array
	 */
	public function getSectionTemplates()
	{
		return \Controller::getTemplateGroup('block_section');
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