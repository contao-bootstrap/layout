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
		$replaceClasses = Bootstrap::getConfigVar('layout.replace-css-classes');

		if (empty($replaceClasses)) {
			return $buffer;
		}

		$classes = array_keys($replaceClasses);
		$classes = array_map(function($class) { return preg_quote($class, '~'); }, $classes);

		$search = sprintf('~class="([^"]*(%s)[^"]*)"~', implode('|', $classes));

		$buffer = preg_replace_callback(
			$search,
			function ($matches) use($replaceClasses) {
				$classes = explode(' ', $matches[1]);
				$classes = array_filter($classes);

				foreach ($classes as $index => $class) {
					if (array_key_exists($class, $replaceClasses)) {
						$classes[$index] = $replaceClasses[$class];
					}
				}

				return sprintf('class="%s"', implode(' ', $classes));
			},
			$buffer
		);

		return $buffer;
	}
} 