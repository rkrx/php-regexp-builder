<?php
namespace Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

class UTF8 implements SpecialCharacter {
	const HEX = 0;
	const INT = 1;

	/**
	 * @var string
	 */
	private $character = null;

	/**
	 * @param int|string $index
	 * @param int $interpreter
	 */
	public function __construct($index, $interpreter = self::INT) {
		if($interpreter == self::HEX) {
			$index = hexdec($index);
			$interpreter = self::INT;
		}

		if($interpreter == self::INT) {
			$this->character = sprintf('\\x{%04X}', $index);
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->character;
	}
}