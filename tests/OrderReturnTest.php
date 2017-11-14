<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'orret_123');

class OrderReturnTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/order_returns'
        );
        $resources = OrderReturn::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\OrderReturn", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/order_returns/' . TEST_RESOURCE_ID
        );
        $resource = OrderReturn::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\OrderReturn", get_class($resource));
    }
}
