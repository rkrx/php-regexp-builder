<?php
namespace Kir\RegExp\Builder\RegExpBuilder;

use Kir\RegExp\Builder\RegExpBuilder;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

class BuilderTest extends \PHPUnit_Framework_TestCase {
	public function testLineStart() {
		$builder = $this->createBuilder()->lineStart();
		$this->assertEquals('^', $builder->getPlainExpression());
	}

	public function testLineEnd() {
		$builder = $this->createBuilder()->lineEnd();
		$this->assertEquals('$', $builder->getPlainExpression());
	}

	public function testExpect() {
		$this->_testMultipliers('(?:abc)', function () {
			return $this->createBuilder()->expect('abc');
		});
	}

	public function testExpectAny() {
		$this->_testMultipliers('(?:.)', function () {
			return $this->createBuilder()->expectAny('abc');
		});
	}

	public function testExpectAnyOf() {
		$this->_testMultipliers('[\\<\\|\\>]', function () {
			return $this->createBuilder()->expectAnyOf('<|>');
		});
	}

	public function testExpectNoneOf() {
		$this->_testMultipliers('[^\\<\\|\\>]', function () {
			return $this->createBuilder()->expectNoneOf('<|>');
		});
	}

	public function testExpectOneOf() {
		$this->_testMultipliers('(?:a|b|c)', function () {
			return $this->createBuilder()->expectOneOf(['a', 'b', 'c']);
		});
	}

	public function testGroup() {
		$this->_testMultipliers('()', function () {
			return $this->createBuilder()->group('');
		});
	}

	public function testGroupWithAlias() {
		$this->_testMultipliers('(?P<a>)', function () {
			return $this->createBuilder()->group('', 'a');
		});
	}

	public function testComplexCase1() {
		$tagName = $this->createBuilder()
		->expectAnyOf(['-', new SpecialCharacter\AnyLetter()])->onceOrMore();

		$attribute = $this->createBuilder()
		->expect(new SpecialCharacter\AnySpace())->onceOrMore()
		->expect($tagName)->once()
		->expect('="')->once()
		->expectAny()->zeroOrMore()
		->expect('"')->once();

		$tagStart = $this->createBuilder()
		->expect('<')->once()
		->group($tagName, 'tag')->once()
		->expect($attribute)->zeroOrMore()
		->expect('>')->once();

		$tagEnd = $this->createBuilder()
		->expect(['</', new SpecialCharacter\BackReference('tag'), '>'])->once();

		$textContent = $this->createBuilder()
		->expectNoneOf('<>')->onceOrMore();

		$tagBody = $this->createBuilder()
		->group($textContent, 'textBefore')->zeroOrOnce()
		->group($tagStart, 'tagStart')->once()
		->group($textContent, 'content')->zeroOrOnce()
		->group($tagEnd, 'tagEnd')->once()
		->group($textContent, 'textAfter')->zeroOrOnce();

		$pattern = $this->createBuilder()
		->group($tagBody, 'body')->once()
		->compile();

		$this->assertTrue($pattern->test('aaa <a href="uri:none">test</a> bbb'));
		$this->assertFalse($pattern->test('aaa <a href="uri:none">test</b> bbb'));
	}

	private function _testMultipliers($expectedPattern, \Closure $func) {
		$this->assertEquals("{$expectedPattern}", $func()->once()->getPlainExpression());
		$this->assertEquals("{$expectedPattern}?", $func()->zeroOrOnce()->getPlainExpression());
		$this->assertEquals("{$expectedPattern}*?", $func()->zeroOrMore()->getPlainExpression());
		$this->assertEquals("{$expectedPattern}+?", $func()->onceOrMore()->getPlainExpression());
	}

	/**
	 * @return Builder
	 */
	private function createBuilder() {
		return (new RegExpBuilder);
	}
}
 