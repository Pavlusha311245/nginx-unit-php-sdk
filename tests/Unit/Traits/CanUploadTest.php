<?php

use PHPUnit\Framework\TestCase;
use UnitPhpSdk\Traits\CanUpload;
use UnitPhpSdk\Http\UnitRequest;
use UnitPhpSdk\Exceptions\UnitException;
use UnitPhpSdk\Enums\HttpMethodsEnum;
use Faker\Factory as Faker;

uses(TestCase::class);

beforeEach(function () {
    $this->faker = Faker::create();
});

it('sets and gets API endpoint', function () {
    $upload = new class { use CanUpload; };

    $apiEndpoint = $this->faker->url();
    $upload->setApiEndpoint($apiEndpoint);
    expect($upload->getApiEndpoint())->toBe($apiEndpoint);
});

// TODO: fix
//it('uploads data successfully', function () {
//    $upload = new class {
//        use CanUpload;
//        public function toArray() {
//            return ['key' => $this->faker->word];
//        }
//    };
//
//    $request = Mockery::mock(UnitRequest::class);
//    $request->shouldReceive('setMethod')->with(HttpMethodsEnum::PUT->value)->andReturnSelf();
//    $request->shouldReceive('send')->with(Mockery::any(), true, ['json' => ['key' => Mockery::any()]])->andReturnSelf();
//
//    $apiEndpoint = $this->faker->url;
//    $upload->setApiEndpoint($apiEndpoint);
//
//    try {
//        $upload->upload($request);
//        expect(true)->toBeTrue();
//    } catch (UnitException $e) {
//        expect(false)->toBeTrue();
//    }
//});

it('throws exception during upload', function () {
    $upload = new class {
        use CanUpload;
        public function toArray() {
            return ['key' => 'value'];
        }
    };

    $request = Mockery::mock(UnitRequest::class);
    $request->shouldReceive('setMethod')->with(HttpMethodsEnum::PUT->value)->andReturnSelf();
    $request->shouldReceive('send')->andThrow(UnitException::class, 'Upload failed');

    $apiEndpoint = $this->faker->url();
    $upload->setApiEndpoint($apiEndpoint);

    expect(fn() => $upload->upload($request))->toThrow(UnitException::class, 'Upload failed');
});

it('removes data successfully', function () {
    $upload = new class {
        use CanUpload;
    };

    $request = Mockery::mock(UnitRequest::class);
    $request->shouldReceive('setMethod')->with(HttpMethodsEnum::DELETE->value)->andReturnSelf();
    $request->shouldReceive('send')->with(Mockery::any())->andReturnSelf();

    $apiEndpoint = $this->faker->url();
    $upload->setApiEndpoint($apiEndpoint);

    try {
        $upload->remove($request);
        expect(true)->toBeTrue();
    } catch (UnitException $e) {
        expect(false)->toBeTrue();
    }
});

it('throws exception during remove', function () {
    $upload = new class {
        use CanUpload;
    };

    $request = Mockery::mock(UnitRequest::class);
    $request->shouldReceive('setMethod')->with(HttpMethodsEnum::DELETE->value)->andReturnSelf();
    $request->shouldReceive('send')->andThrow(UnitException::class, 'Remove failed');

    $apiEndpoint = $this->faker->url();
    $upload->setApiEndpoint($apiEndpoint);

    expect(fn() => $upload->remove($request))->toThrow(UnitException::class, 'Remove failed');
});