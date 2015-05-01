<?php
namespace Kir\RegExp\Builder;

use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\AnyDigit;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\AnyLetter;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\AnySpace;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\UTF8;

class RegExpBuilderTest extends \PHPUnit_Framework_TestCase {
	public function test1() {
		$pattern = (new RegExpBuilder)
		->lineStart()
		->expect(['hello', new AnySpace, 'world'])->once()
		->expectAnyOf('[]')->once()
		->expect(
			(new RegExpBuilder)
			->expect('test')->once()
			->expect(' ')->once()
			->expect(new UTF8(8364))->once()
			->expect(' ')->once()
			->expect('a')->zeroOrOnce()
			->expect(' ')->once()
			->expect('b')->limit(3, 6)
			->expectAny()->once()
			->expect('c')->exactly(6)
		)->once()
		->expectAnyOf('[]')->once()
		->lineEnd()
		->compile();

		$this->assertEquals('/^(?:hello\\sworld)[\\[\\]](?:(?:test)(?: )(?:\\x{20AC})(?: )(?:a)?(?: )(?:b){3,6}(?:.)(?:c){6})[\\[\\]]$/u', (string) $pattern);
	}

	public function test2() {
		$invalidEndingCharacters = (new RegExpBuilder)
		->expectAnyOf('.-')
		->once();

		$namePattern = (new RegExpBuilder)
		->assertNotPrecededBy($invalidEndingCharacters)
		->expectAnyOf(['._-+', new AnyLetter, new AnyDigit])->onceOrMore()
		->assertNotFollowedBy($invalidEndingCharacters);

		$domainPattern = (new RegExpBuilder)
		->assertNotPrecededBy($invalidEndingCharacters)
		->expectAnyOf(['.-', new AnyLetter, new AnyDigit])->onceOrMore()
		->assertNotFollowedBy($invalidEndingCharacters);

		$pattern = (new RegExpBuilder)
		->lineStart()
		->group($namePattern, 'a')->once()
		->expect('@')->once()
		->group($domainPattern, 'b')->once()
		->lineEnd()
		->compile();

		$this->assertEquals('/^(?P<a>(?<![\\.\\-])[\\._\\-\\+\\p{L}\\d]+?(?![\\.\\-]))(?:@)(?P<b>(?<![\\.\\-])[\\.\\-\\p{L}\\d]+?(?![\\.\\-]))$/u', (string) $pattern);
		$this->assertTrue($pattern->test('max.mustermann+github@googlemail.com'));

		$groups = $pattern->getGroups('max.mustermann+github@googlemail.com');
		$this->assertArrayHasKey('a', $groups);
		$this->assertArrayHasKey('b', $groups);
		$this->assertEquals('max.mustermann+github', $groups['a']);
		$this->assertEquals('googlemail.com', $groups['b']);
	}

	public function test3() {
		$pattern = (new RegExpBuilder)
		->assertNotPrecededBy(
			(new RegExpBuilder)
			->expect('\\')->once()
		)->expect(
			(new RegExpBuilder)
			->expect('\\')->exactly(2)
		)->zeroOrMore()
		->expect('?')->once()
		->compile();

		$this->assertEquals('/(?<!(?:\\\\))(?:(?:\\\\){2})*?(?:\\?)/u', (string) $pattern);
		$this->assertTrue($pattern->test('?'));
		$this->assertFalse($pattern->test('\\?'));
		$this->assertTrue($pattern->test('\\\\?'));
		$this->assertFalse($pattern->test('\\\\\\?'));
		$this->assertTrue($pattern->test('\\\\\\\\?'));
	}
}
 