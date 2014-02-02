<?php
namespace Kir\RegExp\Builder;

use Kir\RegExp\Builder\RegExpBuilder\Builder;

class RegExpBuilder {
	/**
	 * @return RegExpBuilder\Builder
	 */
	public static function createBuilder() {
		$modifiers = new Builder\Modifiers();
		$modifiers->addModifier('u');
		$stream = new Builder\Stream();
		return new Builder($modifiers, $stream);
	}
}