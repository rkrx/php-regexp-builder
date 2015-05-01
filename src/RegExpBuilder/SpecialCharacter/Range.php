<?php
namespace Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

class Range implements SpecialCharacter {
	/** @var string */
	private $start;
	/** @var string */
	private $end;

	/**
	 * @param string $start
	 * @param string $end
	 */
	public function __construct($start, $end) {
		$this->start = $start;
		$this->end = $end;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return "{$this->start}-{$this->end}";
	}
}
