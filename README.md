php-regexp-builder
==================

Human-friendly regular expression authoring

[![Build Status](https://travis-ci.org/rkrx/php-regexp-builder.svg?branch=master)](https://travis-ci.org/rkrx/php-regexp-builder)

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
var_dump($res); // true

$res = $pattern->getGroups('max.mustermann+github@googlemail.com');
print_r($res);
```

Output:
```
/^(?P<a>(?<![\.\-])[\._\-\+\p{L}\d]+?(?![\.\-]))(?:@)(?P<b>(?<![\.\-])[\.\-\p{L}\d]+?(?![\.\-]))$/u
bool(true)
Array
(
    [a] => max.mustermann+github
    [0] => max.mustermann+github
    [b] => googlemail.com
    [1] => googlemail.com
)
```