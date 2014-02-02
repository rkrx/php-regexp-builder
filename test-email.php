<?php
namespace Example;

use Kir\RegExp\Builder\RegExpBuilder;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\AnyLetter;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\AnyDigit;

require 'vendor/autoload.php';

$factory = new RegExpBuilder();

$invalidEndingCharacters = $factory->createBuilder()
->expectAnyOf('.-')
->once();

$namePattern = $factory::createBuilder()
->assertNotPrecededBy($invalidEndingCharacters)
->expectAnyOf(['._-+', new AnyLetter, new AnyDigit])->onceOrMore()
->assertNotFollowedBy($invalidEndingCharacters);

$domainPattern = $factory::createBuilder()
->assertNotPrecededBy($invalidEndingCharacters)
->expectAnyOf(['.-', new AnyLetter, new AnyDigit])->onceOrMore()
->assertNotFollowedBy($invalidEndingCharacters);

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


