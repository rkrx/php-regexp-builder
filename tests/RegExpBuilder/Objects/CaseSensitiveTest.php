<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder;

class CaseSensitiveTest extends \PHPUnit_Framework_TestCase {
	public function test() {
		$pattern = (new RegExpBuilder)
		->expect(new CaseSensitive(new Text('<test>')))->once()
		->compile();

		$this->assertTrue($pattern->test('<test>'));
		$this->assertFalse($pattern->test('<tEst>'));
		$this->assertFalse($pattern->test('<TEST>'));
	}
}
 