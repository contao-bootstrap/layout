<?php

/**
 * @package    dev
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2014 netzmacht creative David Molineus
 * @license    LGPL 3.0
 * @filesource
 *
 */

namespace Netzmacht\Bootstrap\Layout\Templates;


use Netzmacht\Bootstrap\Core\Bootstrap;

class Modifier
{
	/**
	 * @param string $buffer
	 * @return string
	 */
	public static function replaceCssClasses($buffer)
	{
		$classes = Bootstrap::getConfigVar('layout.replace-css-classes');

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
} 