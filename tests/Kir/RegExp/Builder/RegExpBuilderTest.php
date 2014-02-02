<?php
namespace Kir\RegExp\Builder;

class RegExpBuilderTest extends \PHPUnit_Framework_TestCase {
	public function testCreate() {
		$instance = (new RegExpBuilder);
		$this->assertInstanceOf("Kir\\RegExp\\Builder\\RegExpBuilder\\Builder", $instance);
	}
}
 