<?php

use UnitPhpSdk\Config\Application\JavaApplication;
use UnitPhpSdk\Exceptions\RequiredKeyException;

it('should initialize JavaApplication', function () {
    $app = new JavaApplication();
    expect($app)->toBeInstanceOf(JavaApplication::class);
});

it('should set and get webApp', function () {
    $app = new JavaApplication();
    $app->setWebApp('myWebApp');
    expect($app->getWebApp())->toBe('myWebApp');
});

it('should set and get options', function () {
    $app = new JavaApplication();
    $options = ['option1' => 'value1', 'option2' => 'value2'];
    $app->setOptions($options);
    expect($app->getOptions())->toBeArray()->and(fn($opts) => $opts['option1'] === 'value1' && $opts['option2'] === 'value2'
    );
});

it('should set and get classPath', function () {
    $app = new JavaApplication();
    $classPath = ['/path/to/app1', '/path/to/app2'];
    $app->setClassPath($classPath);
    expect($app->getClassPath())->toBeArray()->and(fn($cp) => $cp[0] === '/path/to/app1' && $cp[1] === '/path/to/app2'
    );
});

it('should throw RequiredKeyException when try to parseFromArray with insufficient data', function () {
    $app = new JavaApplication();
    $data = ['user' => 'myUser', 'group' => 'myGroup'];
    $app->parseFromArray($data);
})->throws(RequiredKeyException::class, 'webapp');

// TODO: fix tests

//it('should parseFromArray correctly', function () {
//    $app = new JavaApplication();
//    $data = [
//        'type' => 'java',
//        'user' => 'myUser',
//        'group' => 'myGroup',
//        'working_directory' => '/my/dir',
//        'stderr' => '/my/stderr',
//        'stdout' => '/my/stdout',
//        'webapp' => 'myWebApp',
//        'options' => ['option1' => 'value1', 'option2' => 'value2'],
//        'classpath' => ['/path/to/app1', '/path/to/app2'],
//        'threads' => 5,
//        'thread_stack_size' => 3456,
//    ];
//    $app->parseFromArray($data);
//
//    // Assert properties are set correctly
//    expect($app->getType())->toBe($data['type'])
//        ->and($app->getUser())->toBe($data['user'])
//        ->and($app->getGroup())->toBe($data['group'])
//        ->and($app->getWorkingDirectory())->toBe($data['working_directory'])
//        ->and($app->getStdErr())->toBe($data['stderr'])
//        ->and($app->getStdOut())->toBe($data['stdout'])
//        ->and($app->getWebApp())->toBe($data['webapp'])
//        ->and($app->getOptions())->toBeArray()->and(fn($opts) => $opts['option1'] === 'value1' && $opts['option2'] === 'value2'
//        )
//        ->and($app->getClassPath())->toBeArray()->and(fn($cp) => $cp[0] === '/path/to/app1' && $cp[1] === '/path/to/app2'
//        )
//        ->and($app->getThreads())->toBe($data['threads'])
//        ->and($app->getThreadStackSize())->toBe($data['thread_stack_size']);
//});

//it('should convert toArray correctly', function () {
//    $app = new JavaApplication();
//    $data = [
//        'type' => 'java',
//        'user' => 'myUser',
//        'group' => 'myGroup',
//        'working_directory' => '/my/dir',
//        'stderr' => '/my/stderr',
//        'stdout' => '/my/stdout',
//        'webapp' => 'myWebApp',
//        'options' => ['option1' => 'value1', 'option2' => 'value2'],
//        'classpath' => ['/path/to/app1', '/path/to/app2'],
//        'threads' => 5,
//        'thread_stack_size' => 3456,
//    ];
//    $app->parseFromArray($data);
//
//    // Assert array structure is correct
//    expect($app->toArray())->toBeArray()->and(fn(array $appArray) => $appArray['type'] === $data['type'] &&
//        $appArray['user'] === $data['user'] &&
//        $appArray['group'] === $data['group'] &&
//        $appArray['working_directory'] === $data['working_directory'] &&
//        $appArray['stderr'] === $data['stderr'] &&
//        $appArray['stdout'] === $data['stdout'] &&
//        $appArray['webapp'] === $data['webapp'] &&
//        $appArray['options'] === $data['options'] &&
//        $appArray['classpath'] === $data['classpath'] &&
//        $appArray['threads'] === $data['threads'] &&
//        $appArray['thread_stack_size'] === $data['thread_stack_size']
//    );
//});