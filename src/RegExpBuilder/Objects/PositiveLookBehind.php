<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;

class PositiveLookBehind implements Expression {
	use Expression\CacheAware;

	/** @var MixedExpression */
	private $expression = null;

	/**
	 * @param MixedExpression $expression
	 */
	public function __construct(MixedExpression $expression) {
		$this->expression = $expression;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->cache(function () {
			$expression = (string) $this->expression;
			return "(?<={$expression})";
		});
	}
}
