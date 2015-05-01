<?php
namespace Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

class AnyDigit implements SpecialCharacter {
	/**
	 * @return string
	 */
	public function __toString() {
		return '\\d';
	}
}
