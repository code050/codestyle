<?php

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,

    /* Alias */
    'set_type_to_cast' => true,

    'array_push' => true,

    'no_mixed_echo_print' => [
        'use' => 'echo',
    ],

    /* Array Notation */
    'array_syntax' => [
        'syntax' => 'short'
    ],

    'strict_param' => true,
    'no_whitespace_before_comma_in_array'
]);
