<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Objects;

use Kir\RegExp\Builder\RegExpBuilder;

class CaseInsensitiveTest extends \PHPUnit_Framework_TestCase {
	public function test() {
		$pattern = RegExpBuilder::createBuilder()
		->expect(new CaseInsensitive(new Text('<test>')))->once()
		->compile();

		$this->assertTrue($pattern->test('<test>'));
		$this->assertTrue($pattern->test('<tEst>'));
		$this->assertTrue($pattern->test('<TEST>'));
	}
}
 