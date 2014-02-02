php-regexp-builder
==================

Human-friendly regular expression authoring

```PHP
<?php

/* ... */

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
var_dump($res);

$res = $pattern->getGroups('max.mustermann+github@googlemail.com');
var_dump($res);
```