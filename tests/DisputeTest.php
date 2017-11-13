<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'dp_123');

class DisputeTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/disputes'
        );
        $resources = Dispute::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Dispute", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/disputes/' . TEST_RESOURCE_ID
        );
        $resource = Dispute::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Dispute", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Dispute::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/disputes/' . TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertSame("Stripe\\Dispute", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/disputes/' . TEST_RESOURCE_ID
        );
        $resource = Dispute::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Dispute", get_class($resource));
    }

    public function testIsClosable()
    {
        $dispute = Dispute::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/disputes/' . $dispute->id . '/close'
        );
        $resource = $dispute->close();
        $this->assertSame("Stripe\\Dispute", get_class($resource));
        $this->assertSame($resource, $dispute);
    }
}
