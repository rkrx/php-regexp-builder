<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Builder;

class Stream {
	/** @var object[] */
	private $objects = '';

	/**
	 * @param string|object $object
	 */
	public function add($object) {
		$this->objects[] = $object;
	}

	/**
	 * @return object[]
	 */
	public function getAll() {
		return $this->objects;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		$result = '';
		foreach($this->objects as $object) {
			$result .= (string) $object;
		}
		return $result;
	}
}
