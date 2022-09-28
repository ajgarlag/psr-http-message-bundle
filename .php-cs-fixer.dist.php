<?php

/*
 * PsrHttpMessageBundle by @ajgarlag
 *
 * Copyright (c) 2010-2022 Fabien Potencier
 * Copyright (c) 2022 Antonio J. García Lagar
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!file_exists(__DIR__.'/src')) {
    exit(0);
}

$header = <<<EOF
PsrHttpMessageBundle by @ajgarlag

Copyright (c) 2010-2022 Fabien Potencier
Copyright (c) 2022 Antonio J. García Lagar

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHPUnit75Migration:risky' => true,
        'php_unit_dedicate_assert' => ['target' => '5.6'],
        'phpdoc_no_empty_return' => false, // triggers almost always false positive
        'array_syntax' => ['syntax' => 'short'],
        'fopen_flags' => false,
        'ordered_imports' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => true],
        'protected_to_private' => false,
        'combine_nested_dirname' => true,
        'header_comment' => ['header' => $header],
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__.'/{src,tests}')
            ->exclude(['cache'])
            ->append([__FILE__])
    )
;
