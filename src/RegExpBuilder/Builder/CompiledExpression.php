<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Builder;

class CompiledExpression {
	/**
	 * @var string
	 */
	private $pattern = '';

	/**
	 * @param string $pattern
	 */
	public function __construct($pattern) {
		$this->pattern = $pattern;
	}

	/**
	 * @param string $string
	 * @return bool
	 */
	public function test($string) {
		return (bool) preg_match($this->pattern, $string);
	}

	/**
	 * @param string $string
	 * @return string[]
	 */
	public function getGroups($string) {
		$groups = array();
		if((bool) preg_match($this->pattern, $string, $groups)) {
			array_shift($groups);
			return $groups;
		}
		return array();
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->pattern;
	}
}