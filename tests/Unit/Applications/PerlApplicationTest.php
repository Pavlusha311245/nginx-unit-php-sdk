<?php

use UnitPhpSdk\Config\Application\PerlApplication;
use UnitPhpSdk\Exceptions\RequiredKeyException;

it('should initialize PerlApplication', function(){
    $app = new PerlApplication();
    expect($app)->toBeInstanceOf(PerlApplication::class);
});

it('should set and get script', function(){
    $app = new PerlApplication();
    $app->setScript('myScript');
    expect($app->getScript())->toBe('myScript');
});

it('should throw RequiredKeyException when try to parseFromArray with insufficient data', function(){
    $app = new PerlApplication();
    $data = ['user' => 'myUser', 'group' => 'myGroup'];
    $app->parseFromArray($data);
})->throws(RequiredKeyException::class, 'script');

// TODO: fix tests

//it('should parseFromArray correctly', function(){
//    $app = new PerlApplication();
//    $data = [
//        'type' => 'perl',
//        'user' => 'myUser',
//        'group' => 'myGroup',
//        'working_directory' => '/my/dir',
//        'stderr' => '/my/stderr',
//        'stdout' => '/my/stdout',
//        'script' => 'myScript.bsgi',
//        'threads' => 5,
//        'thread_stack_size' => 3456,
//    ];
//    $app->parseFromArray($data);
//
//    // Assert properties are set correctly
//    expect($app->getType())->toBe($data['type']);
//    expect($app->getUser())->toBe($data['user']);
//    expect($app->getGroup())->toBe($data['group']);
//    expect($app->getWorkingDirectory())->toBe($data['working_directory']);
//    expect($app->getStdErr())->toBe($data['stderr']);
//    expect($app->getStdOut())->toBe($data['stdout']);
//    expect($app->getScript())->toBe($data['script']);
//    expect($app->getThreads())->toBe($data['threads']);
//    expect($app->getThreadStackSize())->toBe($data['thread_stack_size']);
//});
//
//it('should convert toArray correctly', function(){
//    $app = new PerlApplication();
//    $data = [
//        'type' => 'perl',
//        'user' => 'myUser',
//        'group' => 'myGroup',
//        'working_directory' => '/my/dir',
//        'stderr' => '/my/stderr',
//        'stdout' => '/my/stdout',
//        'script' => 'myScript.bsgi',
//        'threads' => 5,
//        'thread_stack_size' => 3456,
//    ];
//    $app->parseFromArray($data);
//
//    // Assert array structure is correct
//    expect($app->toArray())->toBeArray()->and(fn (array $appArray) =>
//        $appArray['type'] === $data['type'] &&
//        $appArray['user'] === $data['user'] &&
//        $appArray['group'] === $data['group'] &&
//        $appArray['working_directory'] === $data['working_directory'] &&
//        $appArray['stderr'] === $data['stderr'] &&
//        $appArray['stdout'] === $data['stdout'] &&
//        $appArray['script'] === $data['script'] &&
//        $appArray['threads'] === $data['threads'] &&
//        $appArray['thread_stack_size'] === $data['thread_stack_size']
//    );
//});