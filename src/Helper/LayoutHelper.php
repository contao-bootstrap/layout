<?php

namespace Netzmacht\Bootstrap\Layout\Helper;

use Netzmacht\Bootstrap\Core\Bootstrap;
use Netzmacht\Html\Attributes;

class LayoutHelper
{
	const LEFT   = 'left';
	const RIGHT  = 'right';
	const MAIN   = 'main';
	const HEADER = 'header';
	const FOOTER = 'footer';


	/**
	 * @var \FrontendTemplate
	 */
	protected $template;


	/**
	 * @param \FrontendTemplate $template
	 */
	protected function __construct($template)
	{
		$this->template = $template;
	}


	/**
	 * @return \LayoutModel|null
	 */
	public static function getPageLayout()
	{
		return Bootstrap::getPageLayout();
	}


	/**
	 * @param \FrontendTemplate $template
	 * @return static
	 */
	public static function forTemplate(\FrontendTemplate $template)
	{
		/** @var LayoutHelper $helper */
		$helper = new static($template);
		$helper->initialize();

		return $helper;
	}


	/**
	 * @return bool
	 */
	public static function isBootstrapLayout()
	{
		$layout = static::getPageLayout();

		return $layout && $layout->layoutType == 'bootstrap';
	}


	/**
	 * @param $id
	 * @param bool $inside
	 * @return \Netzmacht\Html\Attributes
	 */
	public function getAttributes($id, $inside=false)
	{
		$layout     = static::getPageLayout();
		$attributes = new Attributes();

		if($inside) {
			$attributes->addClass('inside');
		}
		else {
			$attributes->setId($id);
		}

		if(static::isGridActive()) {
			$key = sprintf('bootstrap_%sClass', $id);

			if($layout->$key) {
				$attributes->addClass($layout->$key);
			}
		}

		return $attributes;
	}

	/**
	 * @return bool
	 */
	public function isGridActive()
	{
		$layout = static::getPageLayout();

		return $layout->cols != '';
	}


	/**
	 * @param $id
	 * @param string $template
	 * @param bool $renderEmpty
	 * @return string
	 */
	public function getCustomSection($id, $template=null, $renderEmpty=false)
	{
		// section specification can be passed instead of the id
		if(is_array($id)) {
			$sectionSpec = $id;
			$id          = $sectionSpec['id'];
		}
		else {
			$sectionSpec = $this->getSectionSpecification($id);
		}

		if(!$renderEmpty && (!isset($this->template->sections[$id]) || ! $this->template->sections[$id])) {
			return '';
		}

		if($template === null) {
			if($sectionSpec && $sectionSpec['template'] != '') {
				$template = $sectionSpec['template'];
			}
			else {
				$template = 'block_section';
			}
		}

		// fallback for older Contao versions
		if(version_compare(VERSION, '3.3', '<')) {
			$blockTemplate          = new \FrontendTemplate($template);
			$blockTemplate->id      = $id;
			$blockTemplate->content = $this->template->sections[$id];

			return $blockTemplate->parse();
		}

		return $this->template->section($id, $template);
	}


	/**
	 * @param $position
	 * @param string $template
	 * @return string
	 */
	public function getCustomSections($position, $template='block_sections')
	{
		$specifications = $this->getSectionSpecifications($position);
		$sections       = array();

		foreach($specifications as $section) {
			$buffer = $this->getCustomSection($section);

			if($buffer) {
				$sections[$section['id']] = $buffer;
			}
		}

		if(!$sections) {
			return '';
		}

		$template = new \FrontendTemplate($template);
		$template->sections = $sections;

		return $template->parse();
	}


	/**
	 * Initialize the system
	 */
	private function initialize()
	{
		if(!$this->isBootstrapLayout()) {
			return;
		}

		$layout = static::getPageLayout();

		// only apply viewport if not contao 3.3 is used
		// TODO: Test it in 3.3
		if($layout->viewport && version_compare(VERSION, '3.3', '<')) {
			$this->template->viewport = sprintf('<meta name="viewport" content="%s">', $layout->viewport);
		}
	}


	/**
	 * @param $id
	 * @return bool
	 */
	private function getSectionSpecification($id)
	{
		$sections = $this->getSectionSpecifications();

		foreach($sections as $section) {
			if($section['id'] == $id) {
				return $section;
			}
		}

		return false;
	}


	/**
	 * @param string|null $position
	 * @return mixed
	 */
	private function getSectionSpecifications($position=null)
	{
		$layout   = static::getPageLayout();
		$sections = deserialize($layout->bootstrap_sections, true);

		if($position !== null) {
			$sections = array_filter($sections, function($section) use($position) {
				return $section['position'] == $position;
			});
		}

		return $sections;
	}

} 