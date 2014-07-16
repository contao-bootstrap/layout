<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Layout\Contao;


use Netzmacht\Bootstrap\Core\Bootstrap;

class Hooks
{

	/**
	 * @param string $buffer
	 * @return string
	 */
	public static function replaceCssClasses($buffer)
	{
		$classes = Bootstrap::getConfigVar('layout.rewrite-css-classes');

		if (empty($classes)) {
			return $buffer;
		}

		$classes = array_keys($classes);
		$classes = array_map(function($class) { return preg_quote($class, '~'); }, $classes);

		$search = sprintf('~class="([^"]*(%s)[^"]*)"~', implode('|', $classes));

		$buffer = preg_replace_callback(
			$search,
			function ($matches) {
				$classes = explode(' ', $matches[1]);
				$classes = array_filter($classes);

				foreach ($classes as $index => $class) {
					if (Bootstrap::getConfig()->has('layout.rewrite-css-classes.' . $class)) {
						$classes[$index] = Bootstrap::getConfigVar('layout.rewrite-css-classes.' . $class);
					}
				}

				return sprintf('class="%s"', implode(' ', $classes));
			},
			$buffer
		);

		return $buffer;
	}


	/**
	 * @param \Template $template
	 */
	public static function replaceImageClasses(\Template $template)
	{
		if (empty($template->imgSize)) {
			return;
		}

		$cssClasses   = $template->class;
		$cssClasses   = trimsplit(' ', $cssClasses);
		$imageClasses = array();

		foreach ($cssClasses as $index => $cssClass) {
			if (substr($cssClass, 0, 4) == 'img-') {
				$imageClasses[] = $cssClass;
				unset($cssClasses[$index]);
			}
		}

		if (count($imageClasses)) {
			$template->class    = implode(' ', $cssClasses);
			$template->imgSize .= sprintf(' class="%s"', implode(' ', $imageClasses));
		}
	}

} 