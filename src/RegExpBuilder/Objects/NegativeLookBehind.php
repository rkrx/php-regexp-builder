<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;

class NegativeLookBehind implements Expression {
	use Expression\CacheAware;

	/** @var Expression */
	private $expression = null;

	/**
	 * @param Expression $expression
	 */
	public function __construct(Expression $expression) {
		$this->expression = $expression;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->cache(function () {
			$expression = (string) $this->expression;
			return "(?<!{$expression})";
		});
	}
}
