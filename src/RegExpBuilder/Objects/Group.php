<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;
use Kir\RegExp\Builder\RegExpBuilder\Expression\CacheAware;

class Group implements Expression {
	use Expression\CacheAware;

	/**
	 * @var string
	 */
	private $expression = null;

	/**
	 * @var null|string
	 */
	private $alias = null;

	/**
	 * @param Expression $expression
	 * @param null|string $alias
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