<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 're_123');

class RefundTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/refunds'
        );
        $resources = Refund::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Refund", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/refunds/' . TEST_RESOURCE_ID
        );
        $resource = Refund::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Refund", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/refunds'
        );
        $resource = Refund::create(array(
            "charge" => "ch_123"
        ));
        $this->assertSame("Stripe\\Refund", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Refund::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/refunds/' . TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertSame("Stripe\\Refund", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/refunds/' . TEST_RESOURCE_ID
        );
        $resource = Refund::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Refund", get_class($resource));
    }
}
