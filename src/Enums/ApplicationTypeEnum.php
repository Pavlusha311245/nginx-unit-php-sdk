<?php

namespace UnitPhpSdk\Enums;

use UnitPhpSdk\Config\Application\JavaApplication;
use UnitPhpSdk\Config\Application\PerlApplication;
use UnitPhpSdk\Config\Application\PhpApplication;
use UnitPhpSdk\Config\Application\PythonApplication;
use UnitPhpSdk\Config\Application\RubyApplication;

enum ApplicationTypeEnum: string
{
    case java = JavaApplication::class;
    case perl = PerlApplication::class;
    case php = PhpApplication::class;
    case python = PythonApplication::class;
    case ruby = RubyApplication::class;
}
