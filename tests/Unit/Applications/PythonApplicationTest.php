<?php

use UnitPhpSdk\Config\Application\PythonApplication;
use UnitPhpSdk\Config\Application\Targets\PythonTarget;
use UnitPhpSdk\Exceptions\RequiredKeyException;
use UnitPhpSdk\Exceptions\UnitException;

it('should initialize PythonApplication', function () {
    $app = new PythonApplication();
    expect($app)->toBeInstanceOf(PythonApplication::class);
});

it('should set and get module', function () {
    $app = new PythonApplication();
    $app->setModule('myModule');
    expect($app->getModule())->toBe('myModule');
});

it('should set and get callable', function () {
    $app = new PythonApplication();
    $app->setCallable('myCallable');
    expect($app->getCallable())->toBe('myCallable');
});

it('should set and get home', function () {
    $app = new PythonApplication();
    $app->setHome('myHome');
    expect($app->getHome())->toBe('myHome');
});

it('should set and get path', function () {
    $app = new PythonApplication();
    $app->setPath('myPath');
    expect($app->getPath())->toBe('myPath');
});

it('should set and get prefix', function () {
    $app = new PythonApplication();
    $app->setPrefix('myPrefix');
    expect($app->getPrefix())->toBe('myPrefix');
});

it('should set and get protocol', function () {
    $app = new PythonApplication();
    $app->setProtocol('myProtocol');
    expect($app->getProtocol())->toBe('myProtocol');
});

it('should throw RequiredKeyException when try to parseFromArray with insufficient data', function () {
    $app = new PythonApplication();
    $data = ['user' => 'myUser', 'group' => 'myGroup'];
    $app->parseFromArray($data);
})->throws(RequiredKeyException::class, 'module');

// TODO: fix tests

//it('should parseFromArray correctly', function () {
//    $app = new PythonApplication();
//    $data = [
//        'type' => 'python',
//        'path' => 'myPath',
//        'protocol' => 'myProtocol',
//        'home' => '/my/home',
//        'callable' => 'myCallable',
//        'prefix' => 'myPrefix',
//        'targets' => ['test' => ['root' => '/var/test']],
//        'user' => 'myUser',
//        'group' => 'myGroup',
//        'working_directory' => '/my/dir',
//        'stderr' => '/my/stderr',
//        'stdout' => '/my/stdout',
//        'module' => 'myModule',
//        'threads' => 5,
//        'thread_stack_size' => 3456,
//    ];
//    $app->parseFromArray($data);
//
//    // Assert properties are set correctly
//    expect($app->getType())->toBe($data['type']);
//    expect($app->getPath())->toBe($data['path']);
//    expect($app->getProtocol())->toBe($data['protocol']);
//    expect($app->getHome())->toBe($data['home']);
//    expect($app->getCallable())->toBe($data['callable']);
//    expect($app->getPrefix())->toBe($data['prefix']);
//    expect($app->getUser())->toBe($data['user']);
//    expect($app->getGroup())->toBe($data['group']);
//    expect($app->getWorkingDirectory())->toBe($data['working_directory']);
//    expect($app->getStdErr())->toBe($data['stderr']);
//    expect($app->getStdOut())->toBe($data['stdout']);
//    expect($app->getModule())->toBe($data['module']);
//    expect($app->getThreads())->toBe($data['threads']);
//    expect($app->getThreadStackSize())->toBe($data['thread_stack_size']);
//});

it(/**
 * @throws UnitException
 * @throws RequiredKeyException
 */ 'should convert toArray correctly', function () {
    $app = new PythonApplication();
    $data = [
        'type' => 'python',
        'path' => 'myPath',
        'protocol' => 'myProtocol',
        'home' => '/my/home',
        'callable' => 'myCallable',
        'prefix' => 'myPrefix',
        'user' => 'myUser',
        'group' => 'myGroup',
        'working_directory' => '/my/dir',
        'stderr' => '/my/stderr',
        'stdout' => '/my/stdout',
        'module' => 'myModule',
        'threads' => 5,
        'thread_stack_size' => 3456,
    ];
    $app->parseFromArray($data);

    // Assert array structure is correct
    expect($app->toArray())->toBeArray()->and(
        fn (array $appArray) => $appArray['type'] === $data['type'] &&
            $appArray['path'] === $data['path'] &&
            $appArray['protocol'] === $data['protocol'] &&
            $appArray['home'] === $data['home'] &&
            $appArray['callable'] === $data['callable'] &&
            $appArray['prefix'] === $data['prefix'] &&
            $appArray['targets']['test']->getRoot() === $data['targets']['test']->getRoot() &&
            $appArray['user'] === $data['user'] &&
            $appArray['group'] === $data['group'] &&
            $appArray['working_directory'] === $data['working_directory'] &&
            $appArray['stderr'] === $data['stderr'] &&
            $appArray['stdout'] === $data['stdout'] &&
            $appArray['module'] === $data['module'] &&
            $appArray['threads'] === $data['threads'] &&
            $appArray['thread_stack_size'] === $data['thread_stack_size']
    );
});
