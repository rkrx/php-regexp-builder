<?php
namespace Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

class NoLetter implements SpecialCharacter {
	/**
	 * @return string
	 */
	public function __toString() {
		return '\P{L}';
	}
}
