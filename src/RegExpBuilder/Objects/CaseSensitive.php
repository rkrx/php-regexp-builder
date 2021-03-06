<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;

class CaseSensitive extends GroupModifier {
	/**
	 * @param Expression $expression
	 */
	public function __construct(Expression $expression) {
		parent::__construct($expression, '-i', 'i');
	}
}
