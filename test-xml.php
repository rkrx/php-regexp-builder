<?php
namespace Example;

use Kir\RegExp\Builder\RegExpBuilder;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter;

require 'vendor/autoload.php';

$factory = new RegExpBuilder();

$tagName = (new RegExpBuilder)
->expectAnyOf(['-', new SpecialCharacter\AnyLetter])->onceOrMore();

$attribute = (new RegExpBuilder)
->expect(new SpecialCharacter\AnySpace)->onceOrMore()
->expect($tagName)->once()
->expect('="')->once()
->expectAny()->zeroOrMore()
->expect('"')->once();

$tagStart = (new RegExpBuilder)
->expect('<')->once()
->group($tagName, 'tag')->once()
->group($attribute)->zeroOrMore()
->expect('>')->once();

$tagEnd = (new RegExpBuilder)
->expect(['</', new SpecialCharacter\BackReference('tag'), '>'])->once();

$textContent = (new RegExpBuilder)
->expectNoneOf('<>')->onceOrMore();

$tagBody = (new RegExpBuilder)
#->group($textContent, 'textBefore')->zeroOrOnce()
->group($tagStart, 'tagStart')->once()
->group($textContent, 'content')->zeroOrOnce()
#->group($factory::createBuilder()->expect(new BackReference('body'))->zeroOrMore(), 'content')->zeroOrOnce()
->group($tagEnd, 'tagEnd')->once()
#->group($textContent, 'textAfter')->zeroOrOnce()
;

$pattern = (new RegExpBuilder)
->group($tagBody, 'body')->once();

echo "{$pattern}\n";
var_dump($pattern->compile()->test('<a href="url:none">test</a>'));
var_dump($pattern->compile()->test('aaa <hello><a href="url:none">test</a></hello> bbb'));
var_dump($pattern->compile()->getGroups('aaa <a href="url:none">test</a> bbb'));