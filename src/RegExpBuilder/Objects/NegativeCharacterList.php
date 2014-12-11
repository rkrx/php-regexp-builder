<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder\Expression;
use Kir\RegExp\Builder\RegExpBuilder\Expression\CacheAware;
use Kir\RegExp\Builder\RegExpBuilder\Builder\Helper;

class NegativeCharacterList implements Expression {
	use Expression\CacheAware;

	/**
	 * @var string|array
	 */
	private $characterList = '';

	/**
	 * @param string|array $characterList
	 */
	public function __construct($characterList) {
		$this->characterList = $characterList;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->cache(function () {
			$characters = Helper::sanitizeCharacterList($this->characterList);
			return "[^{$characters}]";
		});
	}
}