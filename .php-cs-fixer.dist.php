<?php
declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/test',
    ]);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@PHP82Migration' => true,
            '@PHP80Migration:risky' => true,
            '@PhpCsFixer:risky' => true,
            '@PSR2' => true,
            'strict_param' => true,

            // header ------------------
            'linebreak_after_opening_tag' => true,
            'no_leading_namespace_whitespace' => true,

            'no_unused_imports' => true,

            // comment ------------------
            'align_multiline_comment' => true,

            'no_empty_comment' => true,
            'no_empty_phpdoc' => true,
            'no_empty_statement' => true,

            // array ------------------
            'array_syntax' => ['syntax' => 'short'],
            'array_indentation' => true,

            'no_superfluous_elseif' => true,
            'no_multiline_whitespace_around_double_arrow' => true,
            'no_trailing_comma_in_singleline_array' => true,
            'no_whitespace_before_comma_in_array' => true,

            // syntax ------------------
            'elseif' => true,
            'compact_nullable_typehint' => true,
            'function_typehint_space' => true,

            // space, line ------------------

            'no_blank_lines_after_class_opening' => true,
            'no_blank_lines_after_phpdoc' => true,
            'no_break_comment' => true,

            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
                'keep_multiple_spaces_after_comma' => false,
            ],

            'no_extra_blank_lines' => [
                'tokens' => ['extra'],
            ],

            'no_whitespace_in_blank_line' => true,

            'blank_line_before_statement' => [
                'statements' => [
                    'break',
                    'continue',
                    'declare',
                    'return',
                    'throw',
                    'try',
                ],
            ],

            'return_type_declaration' => true,

            'no_blank_lines_before_namespace' => false,
            'single_blank_line_before_namespace' => true,

            'multiline_whitespace_before_semicolons' => [
                'strategy' => 'no_multi_line',
            ],

            'binary_operator_spaces' => [
                'operators' => [
                    '=>' => 'single_space',
                    '=' => 'single_space',
                ],
            ],

            'single_line_comment_spacing' => true,

            'phpdoc_align' => [
                'align' => 'left',
            ],

            'no_superfluous_phpdoc_tags' => false,

            'phpdoc_no_package' => false,

            'fully_qualified_strict_types' => true,

            'void_return' => true,

            'global_namespace_import' => [
                'import_classes' => true,
                'import_constants' => true,
                'import_functions' => true,
            ],

            'is_null' => true,

            'yoda_style' => [
                'equal' => false,
                'identical' => false,
                'less_and_greater' => false,
            ],

            'curly_braces_position' => [
                'anonymous_classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
            ],

            'php_unit_test_annotation' => [
                'style' => 'prefix',
            ],

            'php_unit_strict' => [],

            'strict_comparison' => false,

            'no_trailing_comma_in_singleline' => true,

            'ordered_imports' => [
                'sort_algorithm' => 'alpha',
                'imports_order' => [
                    'const',
                    'class',
                    'function',
                ],
            ],

            'blank_line_between_import_groups' => true,

            'ordered_traits' => true,

            'single_trait_insert_per_statement' => false,

            'visibility_required' => true,

            'list_syntax' => [
                'syntax' => 'short',
            ],

            'single_quote' => true,

            'function_declaration' => [
                'closure_function_spacing' => 'none',
                'closure_fn_spacing' => 'none',
            ],

            'static_lambda' => true,

            'simple_to_complex_string_variable' => true,
        ]
    )
    ->setFinder($finder);
