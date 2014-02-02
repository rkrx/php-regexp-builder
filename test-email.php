<?php
namespace Example;

use Kir\RegExp\Builder\RegExpBuilder;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\AnyLetter;
use Kir\RegExp\Builder\RegExpBuilder\SpecialCharacter\AnyDigit;

require 'vendor/autoload.php';

$invalidEndingCharacters = (new RegExpBuilder)
->expectAnyOf('.-')
->once();

$namePattern = (new RegExpBuilder)
->assertNotPrecededBy($invalidEndingCharacters)
->expectAnyOf(['._-+', new AnyLetter, new AnyDigit])->onceOrMore()
->assertNotFollowedBy($invalidEndingCharacters);

$domainPattern = (new RegExpBuilder)
->assertNotPrecededBy($invalidEndingCharacters)
->expectAnyOf(['.-', new AnyLetter, new AnyDigit])->onceOrMore()
->assertNotFollowedBy($invalidEndingCharacters);

$pattern = (new RegExpBuilder)
->lineStart()
->group($namePattern, 'a')->once()
->expect('@')->once()
->group($domainPattern, 'b')->once()
->lineEnd()
->compile();

echo "{$pattern}\n";

$res = $pattern->test('max.mustermann+github@googlemail.com');
var_dump($res); // true

$res = $pattern->getGroups('max.mustermann+github@googlemail.com');
print_r($res);