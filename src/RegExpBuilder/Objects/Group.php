<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;

class Group implements Expression {
	use Expression\CacheAware;

	/**
	 * @var Expression|string
	 */
	private $expression = null;

	/**
	 * @var string|null
	 */
	private $alias = null;

	/**
	 * @param Expression|string $expression
	 * @param string|null $alias
	 */
	public function __construct($expression, $alias = null) {
		$this->expression = $expression;
		$this->alias = $alias;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->cache(function () {
			$expression = (string) $this->expression;
			$group = $this->alias !== null ? "?P<{$this->alias}>" : '';
			return "({$group}{$expression})";
		});
	}
}
