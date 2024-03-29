<?php

namespace UnitPhpSdk\Enums;

use UnitPhpSdk\Abstract\AbstractApplication;
use UnitPhpSdk\Config\Application\GoExternalApplication;
use UnitPhpSdk\Config\Application\JavaApplication;
use UnitPhpSdk\Config\Application\NodeJsExternalApplication;
use UnitPhpSdk\Config\Application\PerlApplication;
use UnitPhpSdk\Config\Application\PhpApplication;
use UnitPhpSdk\Config\Application\PythonApplication;
use UnitPhpSdk\Config\Application\RubyApplication;
use UnitPhpSdk\Config\Application\WebAssemblyApplication;
use UnitPhpSdk\Config\Application\WebAssemblyComponentApplication;

enum ApplicationTypeEnum: string
{
    case PHP = PhpApplication::class;

    case PERL = PerlApplication::class;

    case PYTHON = PythonApplication::class;

    case RUBY = RubyApplication::class;

    case WASM = WebAssemblyApplication::class;

    case JAVA = JavaApplication::class;

    case WASM_WASI_COMPONENT = WebAssemblyComponentApplication::class;

    case EXTERNAL = NodeJsExternalApplication::class | GoExternalApplication::class;

    public static function getApplication(string $application)
    {
        return match (mb_strtolower($application)) {
            'php' => self::PHP,
            'perl' => self::PERL,
            'python' => self::PYTHON,
            'ruby' => self::RUBY,
            'wasm' => self::WASM,
            'java' => self::JAVA,
            'wasm-wasi-component' => self::WASM_WASI_COMPONENT,
            'external' => self::EXTERNAL,
            default => throw new \InvalidArgumentException('Invalid application type'),
        };
    }

    public static function getApplicationType(AbstractApplication $application): string
    {
        return match (get_class($application)) {
            PhpApplication::class => 'php',
            PerlApplication::class => 'perl',
            PythonApplication::class => 'python',
            RubyApplication::class => 'ruby',
            WebAssemblyApplication::class => 'wasm',
            JavaApplication::class => 'java',
            WebAssemblyComponentApplication::class => 'wasm-wasi-component',
            NodeJsExternalApplication::class | GoExternalApplication::class => 'external',
            default => throw new \InvalidArgumentException('Invalid application type'),
        };
    }
}
