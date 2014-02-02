<?php
namespace Kir\RegExp\Builder;

class RegExpBuilderTest extends \PHPUnit_Framework_TestCase {
	public function testCreate() {
		$instance = RegExpBuilder::createBuilder();
		$this->assertInstanceOf("Kir\\RegExp\\Builder\\RegExpBuilder\\Builder", $instance);
	}
}
 