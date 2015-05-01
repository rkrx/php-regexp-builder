<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;
use Kir\RegExp\Builder\RegExpBuilder\Builder\Helper;

class MixedExpression implements Expression {
	use Expression\CacheAware;

	/**
	 * @var string
	 */
	private $expression = null;

	/**
	 * @param string $expression
	 */
	public function __construct($expression) {
		$this->expression = $expression;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->cache(function () {
			$expression = $this->expression;
			if(is_array($expression)) {
				$expressions = Helper::quoteExpressions($expression);
				return join('', $expressions);
			}
			return Helper::quote($expression);
		});
	}
} 