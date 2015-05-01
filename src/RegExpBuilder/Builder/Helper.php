<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Builder;

use Kir\RegExp\Builder\RegExpBuilder\Builder;
use Kir\RegExp\Builder\RegExpBuilder\Expression;
use Kir\RegExp\Builder\RegExpBuilder\Objects\Text;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

final class Helper {
	/**
	 * @param string|array $characters
	 * @return string
	 * @throws InvalidCharacterException
	 */
	public static function sanitizeCharacterList($characters) {
		if(!is_array($characters)) {
			$characters = array($characters);
		}
		foreach($characters as $idx => &$character) {
			if($character instanceof SpecialCharacter) {
				$character = (string) $character;
			} elseif(!is_string($character)) {
				$idx++;
				throw new InvalidCharacterException("Expected character #{$idx} to be a valid character.");
			} else {
				$character = new Text($character);
			}
		}
		$characters = join('', $characters);
		return $characters;
	}

	/**
	 * @param array $expressions
	 * @return array
	 */
	public static function quoteExpressions(array $expressions) {
		foreach($expressions as &$expression) {
			$expression = Helper::quote($expression);
		}
		return $expressions;
	}

	/**
	 * @param string $string
	 * @return $this
	 */
	public static function quote($string) {
		if($string instanceof SpecialCharacter) {
			return (string) $string;
		} elseif($string instanceof Expression) {
			return (string) $string;
		} elseif($string instanceof Builder) {
			/* @var $string Builder */
			return $string->getPlainExpression();
		}
		return new Text($string);
	}
}
