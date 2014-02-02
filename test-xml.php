<?php
namespace Example;

use Kir\RegExp\Builder\RegExpBuilder;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

require 'vendor/autoload.php';

$factory = new RegExpBuilder();

$tagName = $factory::createBuilder()
->expectAnyOf(['-', new SpecialCharacter\AnyLetter])->onceOrMore();

$attribute = $factory::createBuilder()
->expect(new SpecialCharacter\AnySpace)->onceOrMore()
->expect($tagName)->once()
->expect('="')->once()
->expectAny()->zeroOrMore()
->expect('"')->once();

$tagStart = $factory::createBuilder()
->expect('<')->once()
->group($tagName, 'tag')->once()
->group($attribute)->zeroOrMore()
->expect('>')->once();

$tagEnd = $factory::createBuilder()
->expect(['</', new SpecialCharacter\BackReference('tag'), '>'])->once();

$textContent = $factory::createBuilder()
->expectNoneOf('<>')->onceOrMore();

$tagBody = $factory::createBuilder()
#->group($textContent, 'textBefore')->zeroOrOnce()
->group($tagStart, 'tagStart')->once()
->group($textContent, 'content')->zeroOrOnce()
#->group($factory::createBuilder()->expect(new BackReference('body'))->zeroOrMore(), 'content')->zeroOrOnce()
->group($tagEnd, 'tagEnd')->once()
#->group($textContent, 'textAfter')->zeroOrOnce()
;

$pattern = $factory::createBuilder()
->group($tagBody, 'body')->once();

echo "{$pattern}\n";
var_dump($pattern->compile()->test('<a href="url:none">test</a>'));
var_dump($pattern->compile()->test('aaa <hello><a href="url:none">test</a></hello> bbb'));
var_dump($pattern->compile()->getGroups('aaa <a href="url:none">test</a> bbb'));