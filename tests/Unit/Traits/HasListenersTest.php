<?php
use Pest\TestSuite;
use UnitPhpSdk\Config\Listener;
use UnitPhpSdk\Traits\HasListeners;

it('sets and gets listeners correctly', function () {
    $listenerMock = \Mockery::mock(Listener::class);
    $listenerMock->shouldReceive('getListener')->andReturn('listener1');

    $object = new class {
        use HasListeners;
    };

    // No listeners initially
    $this->assertEquals([], $object->getListeners());
    $this->assertFalse($object->hasListeners());

    // Set a listener
    $object->setListener($listenerMock);

    // Check we now have one listener
    $this->assertEquals(['listener1' => $listenerMock], $object->getListeners());
    $this->assertTrue($object->hasListeners());
});
