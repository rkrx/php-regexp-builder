<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;

class Plain implements Expression {
	/**
	 * @var string
	 */
	private $plain = null;

	/**
	 * @param string $plain
	 */
	public function __construct($plain) {
		$this->plain = $plain;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->plain;
	}
}
