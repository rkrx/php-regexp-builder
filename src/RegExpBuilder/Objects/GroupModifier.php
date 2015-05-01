<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;

abstract class GroupModifier implements Expression {
	use Expression\CacheAware;

	/** @var Expression */
	private $expression = null;
	/** @var string */
	private $modifierStart = null;
	/** @var string */
	private $modifierEnd = null;

	/**
	 * @param Expression $expression
	 * @param string $modifierStart
	 * @param string $modifierEnd
	 */
	public function __construct(Expression $expression, $modifierStart, $modifierEnd) {
		$this->expression = $expression;
		$this->modifierStart = $modifierStart;
		$this->modifierEnd = $modifierEnd;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->cache(function () {
			$expression = (string) $this->expression;
			return "(?:(?{$this->modifierStart}){$expression}(?{$this->modifierEnd}))";
		});
	}
}
