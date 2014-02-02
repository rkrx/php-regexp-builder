<?php
namespace Example;

use Kir\RegExp\Builder\RegExpBuilder;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

require 'vendor/autoload.php';

$pattern = (new RegExpBuilder)
->lineStart()
->expect(['hello', new SpecialCharacter\AnySpace, 'world'])->once()
->expectAnyOf('[]')->once()
->expect(
		(new RegExpBuilder)
		->expect('test')->once()
		->expect(' ')->once()
		->expect(new SpecialCharacter\UTF8(8364))->once()
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

echo "{$pattern}\n";

$res = $pattern->test('hello world[test € a bbb cccccc]');
var_dump($res);

