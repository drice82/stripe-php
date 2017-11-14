<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'po_123');

class PayoutTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/payouts'
        );
        $resources = Payout::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Payout", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/payouts/' . TEST_RESOURCE_ID
        );
        $resource = Payout::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Payout", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/payouts'
        );
        $resource = Payout::create(array(
            "amount" => 100,
            "currency" => "usd"
        ));
        $this->assertSame("Stripe\\Payout", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Payout::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/payouts/' . TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertSame("Stripe\\Payout", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/payouts/' . TEST_RESOURCE_ID
        );
        $resource = Payout::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Payout", get_class($resource));
    }

    public function testIsCancelable()
    {
        $resource = Payout::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/payouts/' . $resource->id . '/cancel'
        );
        $resource->cancel();
        $this->assertSame("Stripe\\Payout", get_class($resource));
    }
}
