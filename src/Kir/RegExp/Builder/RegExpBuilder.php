<?php
namespace Kir\RegExp\Builder;

use Kir\RegExp\Builder\RegExpBuilder\Builder;

class RegExpBuilder extends Builder {
	/**
	 */
	public function __construct() {
		$modifiers = new Builder\Modifiers();
		$modifiers->addModifier('u');
		$stream = new Builder\Stream();
		parent::__construct($modifiers, $stream);
	}

	/**
	 * @return RegExpBuilder\Builder
	 */
	public static function createInstance() {
		return new static();
	}
}