<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'or_123');

class OrderTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/orders'
        );
        $resources = Order::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Order", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/orders/' . TEST_RESOURCE_ID
        );
        $resource = Order::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Order", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/orders'
        );
        $resource = Order::create(array(
            'currency' => 'usd'
        ));
        $this->assertSame("Stripe\\Order", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Order::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/orders/' . TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertSame("Stripe\\Order", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/orders/' . TEST_RESOURCE_ID
        );
        $resource = Order::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Order", get_class($resource));
    }

    public function testIsPayable()
    {
        $resource = Order::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/orders/' . TEST_RESOURCE_ID . '/pay'
        );
        $resource->pay();
        $this->assertSame("Stripe\\Order", get_class($resource));
    }

    public function testIsReturnable()
    {
        $order = Order::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/orders/' . TEST_RESOURCE_ID . '/returns'
        );
        $resource = $order->returnOrder();
        $this->assertSame("Stripe\\OrderReturn", get_class($resource));
    }
}
