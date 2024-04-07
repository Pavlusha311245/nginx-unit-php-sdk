<?php

it('parses valid listener pass strings without target correctly', function () {
    $validStrings = [
        'applications/my-app',
        'routes/default-route',
        'upstreams/my-upstream'
    ];

    foreach ($validStrings as $string) {
        $parsedData = parse_listener_pass($string);

        $this->assertIsArray($parsedData);
        $this->assertArrayHasKey('type', $parsedData);
        $this->assertArrayHasKey('name', $parsedData);
        $this->assertArrayNotHasKey('target', $parsedData);
    }
});

it('parses valid listener pass strings with target correctly', function () {
    $validStrings = [
        'applications/my-app/target1',
        'routes/default-route/target2',
        'upstreams/my-upstream/target3'
    ];

    foreach ($validStrings as $string) {
        $parsedData = parse_listener_pass($string);

        $this->assertIsArray($parsedData);
        $this->assertArrayHasKey('type', $parsedData);
        $this->assertArrayHasKey('name', $parsedData);
        $this->assertArrayHasKey('target', $parsedData);
    }
});

it('throws a ParseError for invalid listener pass strings', function () {
    $invalidStrings = [
        'invalid/type',
        'applicationInvalidPath',
        'routes/InvalidRouteName',
        'applications/app1/target1/extraSegment',
        'routes//my-route',
        'upstreams/upstream-name/',
        'routes/route//target'
    ];

    foreach ($invalidStrings as $string) {
        $this->expectException(ParseError::class);
        $this->expectExceptionMessage('Error when try to parse listenerPass');

        parse_listener_pass($string);
    }
});
