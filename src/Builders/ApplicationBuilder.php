<?php

namespace UnitPhpSdk\Builders;

use UnitPhpSdk\Config\Application\{GoExternalApplication,
    JavaApplication,
    NodeJsExternalApplication,
    PerlApplication,
    PhpApplication,
    PythonApplication,
    RubyApplication,
    WebAssemblyApplication,
    WebAssemblyComponentApplication
};
use UnitPhpSdk\Exceptions\UnitException;

class ApplicationBuilder
{
    /**
     * @throws UnitException
     *
     * TODO: add ApplicationTypeEnum as possible type
     */
    public static function create($appName, $appData, string $type = '')
    {
        $application = match ($type) {
            'php' => new PhpApplication($appName, $appData),
            'java' => new JavaApplication($appName, $appData),
            'perl' => new PerlApplication($appName, $appData),
            'python' => new PythonApplication($appName, $appData),
            'wasm' => new WebAssemblyApplication($appName, $appData),
            'ruby' => new RubyApplication($appName, $appData),
            'wasm-wasi-component' => new WebAssemblyComponentApplication($appName, $appData),
            'external' => self::isNodeJsApplication($appData) ?
                new NodeJsExternalApplication($appName, $appData) :
                new GoExternalApplication($appName, $appData),
        };

        return $application;
    }

    /**
     * Detect if NodeJsExternalApplication
     *
     * @param $appData
     * @return bool
     */
    private static function isNodeJsApplication($appData): bool
    {
        if (str_contains($appData['executable'], '.js')) {
            return true;
        }

        if (array_key_exists('arguments', $appData)) {
            return str_contains(implode(';', $appData['arguments']), '.js');
        }

        return false;
    }
}
