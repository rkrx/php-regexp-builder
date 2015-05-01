<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;

class Text implements Expression {
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
			$expression = (string) $this->expression;
			return preg_quote($expression, '/');
		});
	}
} 