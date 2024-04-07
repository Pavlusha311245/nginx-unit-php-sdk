<?php

use UnitPhpSdk\Config\Application\RubyApplication;
use UnitPhpSdk\Exceptions\RequiredKeyException;

it('checks that RubyApplication correctly sets and gets script values', function () {
    $rubyApplication = new RubyApplication();

    $script = 'example_script';
    $rubyApplication->setScript($script);

    expect($rubyApplication->getScript())->toBe($script);
});

it('checks that RubyApplication correctly sets and gets hooks values', function () {
    $rubyApplication = new RubyApplication();

    $hooks = 'example_hooks';
    $rubyApplication->setHooks($hooks);

    expect($rubyApplication->getHooks())->toBe($hooks);
});

it('checks that RubyApplication throws exception with missing script', function () {
    $rubyApplication = new RubyApplication();

    $array = ['hooks' => 'example_hooks'];

    $codeBlock = function () use ($rubyApplication, $array) {
        $rubyApplication->parseFromArray($array);
    };

    expect($codeBlock)->toThrow(RequiredKeyException::class);
});

it('checks that RubyApplication correctly parses from array', function () {
    $rubyApplication = new RubyApplication();

    $array = ['script' => 'example_script', 'hooks' => 'example_hooks', 'threads' => 4];

    $rubyApplication->parseFromArray($array);

    expect($rubyApplication->getScript())->toBe($array['script'])
        ->and($rubyApplication->getHooks())->toBe($array['hooks']);
    // Here we need to add a getter for threads to test the thread count.
});

//it('checks that RubyApplication returns values as an array', function () {
//    $rubyApplication = new RubyApplication();
//
//    $script = 'example_script';
//    $rubyApplication->setScript($script);
//
//    $hooks = 'example_hooks';
//    $rubyApplication->setHooks($hooks);
//
//    $expectedArray = [
//        'script' => $script,
//        'hooks' => $hooks,
//        // 'threads' => 3, // add this line if threads are part of the returned array
//    ];
//
//    expect($rubyApplication->toArray())->toBe($expectedArray);
//});

// Add more tests if needed ...
