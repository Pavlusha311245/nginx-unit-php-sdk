<?php

use Pest\TestSuite;
use PHPUnit\Framework\Assert;
use UnitPhpSdk\Config\Application\{PhpApplication, Targets\PhpTarget, Targets\PythonTarget};

it('checks if PhpTarget and PythonTarget are set and retrieved properly', function () {
    $application = new PhpApplication();
    $phpTarget = ['root' => '/app', 'script' => 'script.php', 'index' => 'index.php'];
    $pythonTarget = ['module' => 'example_module', 'callable' => 'example_callable'];
    $targets = ['phpTarget' => new PhpTarget($phpTarget), 'pythonTarget' => new PythonTarget($pythonTarget)];
    $application->setTargets($targets);

    expect($application->getTargets())->toEqual($targets);
});

it('checks if hasTargets returns the correct value with PhpTarget and PythonTarget', function () {
    $application = new PhpApplication();
    Assert::assertFalse($application->hasTargets());
    $phpTarget = ['root' => '/app', 'script' => 'script.php', 'index' => 'index.php'];
    $pythonTarget = ['module' => 'example_module', 'callable' => 'example_callable'];
    $targets = ['phpTarget' => new PhpTarget($phpTarget), 'pythonTarget' => new PythonTarget($pythonTarget)];
    $application->setTargets($targets);

    expect($application->hasTargets())->toBeTrue();
});
