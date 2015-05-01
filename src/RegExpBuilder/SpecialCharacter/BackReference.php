<?php
namespace Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

class BackReference implements SpecialCharacter {
	/** @var string */
	private $alias = null;

	/**
	 * @param string $alias
	 */
	public function __construct($alias) {
		$this->alias = $alias;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return "(?P={$this->alias})";
	}
}
