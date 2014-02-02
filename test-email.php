<?php
namespace Example;

use Kir\RegExp\Builder\RegExpBuilder;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\AnyLetter;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\AnyDigit;

require 'vendor/autoload.php';

$factory = new RegExpBuilder();

$namePattern = $factory::createBuilder()
->assertNotPrecededBy($factory->createBuilder()->expectAnyOf('.-')->once())
->expectAnyOf(['._-+', new AnyLetter, new AnyDigit])->onceOrMore()
->assertNotFollowedBy($factory->createBuilder()->expectAnyOf('.-')->once());

$domainPattern = $factory::createBuilder()
->assertNotPrecededBy($factory->createBuilder()->expectAnyOf('.-')->once())
->expectAnyOf(['.-', new AnyLetter, new AnyDigit])->onceOrMore()
->assertNotFollowedBy($factory->createBuilder()->expectAnyOf('.-')->once());

$pattern = $factory::createBuilder()
->lineStart()
->group($namePattern, 'a')->once()
->expect('@')->once()
->group($domainPattern, 'b')->once()
->lineEnd()
->compile();

echo "{$pattern}\n";

$res = $pattern->test('max.mustermann+github@googlemail.com');
var_dump($res);

$res = $pattern->getGroups('max.mustermann+github@googlemail.com');
var_dump($res);


