<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Builder;

class Modifiers {
	/**
	 * @var array
	 */
	private $modifiers = array();

	/**
	 * @param string $modifier
	 * @return bool
	 */
	public function hasModifier($modifier) {
		return in_array($modifier, $this->modifiers);
	}

	/**
	 * @param string $modifier
	 * @return $this
	 */
	public function addModifier($modifier) {
		if(!$this->hasModifier($modifier)) {
			$this->modifiers[] = $modifier;
		}
		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getModifiers() {
		return $this->modifiers;
	}

	/**
	 * @param string $modifier
	 * @return $this
	 */
	public function dropModifier($modifier) {
		$idx = array_search($modifier, $this->modifiers);
		if($idx !== false) {
			unset($this->modifiers[$idx]);
		}
		return $this;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return join('', $this->modifiers);
	}
}
