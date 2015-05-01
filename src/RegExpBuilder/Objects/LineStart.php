<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;

class LineStart implements Expression {
	/**
	 * @return string
	 */
	public function __toString() {
		return '^';
	}
}
