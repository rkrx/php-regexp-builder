<?php
namespace Example;

use Kir\RegExp\Builder\RegExpBuilder;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

require 'vendor/autoload.php';

$pattern = RegExpBuilder::createBuilder()
->assertNotPrecededBy(
	RegExpBuilder::createBuilder()
	->expect('\\')->once()
)
->expect(
	RegExpBuilder::createBuilder()
	->expect('\\')->exactly(2)
)->zeroOrMore()
->expect('?')->once()
->compile();

var_dump((string) $pattern);
var_dump($pattern->test('?')); // expected: true
var_dump($pattern->test('\\?')); // expected: false
var_dump($pattern->test('\\\\?')); // expected: true