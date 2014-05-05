<?php

namespace Netzmacht\Bootstrap\Layout\Helper;


use Netzmacht\Html\Attributes;

class LayoutHelper
{
	const LEFT = 'left';
	const RIGHT = 'right';
	const MAIN = 'main';
	const HEADER = 'header';
	const FOOTER = 'footer';


	/**
	 * @var
	 */
	protected $template;


	/**
	 * @return \LayoutModel|null
	 */
	public static function getPageLayout()
	{
		global $container;

		return $container['bootstrap.page-layout'];
	}


	/**
	 * @param \FrontendTemplate $template
	 * @return static
	 */
	public static function create($template)
	{
		/** @var LayoutHelper $helper */
		$helper =new static($template);
		$helper->initialize();
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
			$attributes->addClass($layout->$key);
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
	 *
	 */
	private function initialize()
	{
		if(!$this->isBootstrapLayout()) {
			return;
		}

		$layout = static::getPageLayout();

		// only apply viewport if not contao 3.3 is used
		if($layout->viewport && version_compare(VERSION, '3.3', '<')) {
			$this->template->viewport = sprintf('<meta name="viewport" content="%s">', $layout->viewport);
		}
	}

} 