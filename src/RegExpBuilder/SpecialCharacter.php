<?php
namespace Kir\RegExp\Builder\RegExpBuilder;

interface SpecialCharacter extends Expression {
	/**
	 * @return string
	 */
	public function __toString();
}
