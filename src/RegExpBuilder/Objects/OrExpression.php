<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Builder;
use Kir\RegExp\Builder\RegExpBuilder\Expression;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

class OrExpression implements Expression {
	use Expression\CacheAware;

	/**
	 * @var MixedExpression[]
	 */
	private $expressions;

	/**
	 * @param MixedExpression[] $expressions
	 */
	public function __construct(array $expressions) {
		$this->expressions = $expressions;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->cache(function () {
			$expressions = $this->sanitizeExpressions($this->expressions);
			return join('|', $expressions);
		});
	}

	/**
	 * @param array $expressions
	 * @return string
	 */
	private function sanitizeExpressions($expressions) {
		foreach($expressions as &$expression) {
			$expression = $this->quote($expression);
		}
		return $expressions;
	}

	/**
	 * @param string $string
	 * @return $this
	 */
	private function quote($string) {
		if($string instanceof SpecialCharacter) {
			return (string) $string;
		} elseif($string instanceof Builder) {
			/* @var $string Builder */
			return $string->getPlainExpression();
		}
		return new Text($string);
	}
}