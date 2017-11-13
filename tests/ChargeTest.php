<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'ch_123');

class ChargeTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/charges'
        );
        $resources = Charge::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Charge", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/charges/' . TEST_RESOURCE_ID
        );
        $resource = Charge::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/charges'
        );
        $resource = Charge::create(array(
            "amount" => 100,
            "currency" => "usd",
            "source" => "tok_123"
        ));
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Charge::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $resource->id
        );
        $resource->save();
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/charges/' . TEST_RESOURCE_ID
        );
        $resource = Charge::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }

    public function testCanMarkAsFraudulent()
    {
        $charge = Charge::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $charge->id,
            array('fraud_details' => array('user_report' => 'fraudulent'))
        );
        $resource = $charge->markAsFraudulent();
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }

    public function testCanMarkAsSafe()
    {
        $charge = Charge::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/charges/' . $charge->id,
            array('fraud_details' => array('user_report' => 'safe'))
        );
        $resource = $charge->markAsSafe();
        $this->assertSame("Stripe\\Charge", get_class($resource));
    }
}
