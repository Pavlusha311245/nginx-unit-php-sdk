<?php

use UnitPhpSdk\Config\Application\Options\PhpOptions;
use UnitPhpSdk\Config\Application\PhpApplication;
use UnitPhpSdk\Exceptions\UnitException;

it('should initialize PhpApplication', function () {
    $app = new PhpApplication();
    expect($app)->toBeInstanceOf(PhpApplication::class);
});

it('should set and get root', function () {
    $app = new PhpApplication();
    $app->setRoot('/var/www');
    expect($app->getRoot())->toBe('/var/www');
});

it('should set and get index', function () {
    $app = new PhpApplication();
    $app->setIndex('myindex.php');
    expect($app->getIndex())->toBe('myindex.php');
});

it('should set and get script', function () {
    $app = new PhpApplication();
    $app->setScript('myscript.php');
    expect($app->getScript())->toBe('myscript.php');
});

it('should set and get options', function () {
    $options = new PhpOptions();
    $optionsData = [
        'admin' => [
            "memory_limit" => "256M",
            "variables_order" => "EGPCS"
        ],
        'user' => [
            "display_errors" => "0",
        ],
        'file' => '/tmp/file.ini',
    ];
    $options->setAdmin($optionsData['admin'])
        ->setUser($optionsData['user'])
        ->setFile($optionsData['file']);

    $app = new PhpApplication();
    $app->setOptions($optionsData);

    expect($app->getOptions())->toBeInstanceOf(PhpOptions::class)
        ->and($app->getOptions()->getAdmin())->toEqual($options->getAdmin())
        ->and($app->getOptions()->getUser())->toEqual($options->getUser())
        ->and($app->getOptions()->getFile())->toEqual($options->getFile());
});

// TODO: fix tests

//it('should throw RequiredKeyException when try to parseFromArray with insufficient data', function () {
//    $app = new PhpApplication();
//    $data = ['targets' => []];
//    $app->parseFromArray($data);
//})->throws(RequiredKeyException::class, 'root');
//
//it('should successfully parseFromArray when given properly formed data', function () {
//    $app = new PhpApplication();
//    $data = [
//        'root' => '/var/www',
//        'targets' => ['test' => ['root' => '/var/test']],
//        'index' => 'myindex.php',
//        'script' => 'myscript.php',
//        'options' => [
//            'admin' => [
//                "memory_limit" => "256M",
//                "variables_order" => "EGPCS"
//            ],
//            'user' => [
//                "display_errors" => "0",
//            ],
//            'file' => '/tmp/file.ini',
//        ],
//    ];
//    $app->parseFromArray($data);
//
//    // Assert properties are set correctly
//    expect($app->getRoot())->toBe($data['root'])
//        ->and($app->getIndex())->toBe($data['index'])
//        ->and($app->getScript())->toBe($data['script'])
//        ->and($app->getOptions()->getAdmin())->toEqual($data['options']['admin'])
//        ->and($app->getOptions()->getUser())->toEqual($data['options']['user'])
//        ->and($app->getOptions()->getFile())->toEqual($data['options']['file']);
//});

it('should set and get user on PhpApplication', function () {
    $app = new PhpApplication();
    $app->setUser('myUser');
    expect($app->getUser())->toBe('myUser');
});

it('should set and get group on PhpApplication', function () {
    $app = new PhpApplication();
    $app->setGroup('myGroup');
    expect($app->getGroup())->toBe('myGroup');
});

it('should set and get working_directory on PhpApplication', function () {
    $app = new PhpApplication();
    $app->setWorkingDirectory('/my/dir');
    expect($app->getWorkingDirectory())->toBe('/my/dir');
});

it('should set and get stderr on PhpApplication', function () {
    $app = new PhpApplication();
    $app->setStdErr('/my/stderr');
    expect($app->getStdErr())->toBe('/my/stderr');
});

it('should set and get stdout on PhpApplication', function () {
    $app = new PhpApplication();
    $app->setStdOut('/my/stdout');
    expect($app->getStdOut())->toBe('/my/stdout');
});

//it('should correctly convert to array', function () {
//    $app = new PhpApplication();
//    $data = [
//        'root' => '/var/www',
//        'targets' => ['test' => ['root' => '/var/test']],
//        'index' => 'myindex.php',
//        'script' => 'myscript.php',
//        'options' => [
//            'admin' => [
//                "memory_limit" => "256M",
//                "variables_order" => "EGPCS"
//            ],
//            'user' => [
//                "display_errors" => "0",
//            ],
//            'file' => '/tmp/file.ini',
//        ],
//    ];
//    // fill properties to match expected array structure
//    $app->setUser('myUser')
//        ->setGroup('myGroup')
//        ->setWorkingDirectory('/my/dir')
//        ->setStdErr('/my/stderr')
//        ->setStdOut('/my/stdout')
//        ->parseFromArray($data);
//
//    // Assert array structure is correct
//    expect($app->toArray())->toBeArray()->and(
//        fn(array $appArray) => $appArray['user'] === 'myUser' &&
//            $appArray['group'] === 'myGroup' &&
//            $appArray['working_directory'] === '/my/dir' &&
//            $appArray['stderr'] === '/my/stderr' &&
//            $appArray['stdout'] === '/my/stdout' &&
//            $appArray['root'] === $data['root'] &&
//            $appArray['index'] === $data['index'] &&
//            $appArray['script'] === $data['script'] &&
//            $appArray['options']->getAdmin() === $data['options']['admin'] &&
//            $appArray['options']->getUser() === $data['options']['user'] &&
//            $appArray['options']->getFile() === $data['options']['file']
//    );
//});
//
it(/**
 * @throws UnitException
 */ 'should correctly convert to JSON', function () {
    $app = new PhpApplication();
    $data = [
        'root' => '/var/www',
        'targets' => ['test' => ['root' => '/var/test']],
        'index' => 'myindex.php',
        'script' => 'myscript.php',
        'options' => [
            'admin' => [
                "memory_limit" => "256M",
                "variables_order" => "EGPCS"
            ],
            'user' => [
                "display_errors" => "0",
            ],
            'file' => '/tmp/file.ini',
        ],
    ];
    // fill properties to match expected JSON structure
    $app->setUser('myUser')
        ->setGroup('myGroup')
        ->setWorkingDirectory('/my/dir')
        ->setStdErr('/my/stderr')
        ->setStdOut('/my/stdout')
        ->parseFromArray($data);

    // Assert JSON structure matches array
    expect(json_decode($app->toJson(), true))->toBeArray()->and(
        fn (array $appArray) => $appArray['user'] === 'myUser' &&
            $appArray['group'] === 'myGroup' &&
            $appArray['working_directory'] === '/my/dir' &&
            $appArray['stderr'] === '/my/stderr' &&
            $appArray['stdout'] === '/my/stdout' &&
            $appArray['root'] === $data['root'] &&
            $appArray['index'] === $data['index'] &&
            $appArray['script'] === $data['script'] &&
            $appArray['options']['admin'] === $data['options']['admin'] &&
            $appArray['options']['user'] === $data['options']['user'] &&
            $appArray['options']['file'] === $data['options']['file']
    );
});
