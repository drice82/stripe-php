<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'src_123');

class SourceTest extends StripeMockTestCase
{
    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/sources/' . TEST_RESOURCE_ID
        );
        $resource = Source::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Source", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/sources'
        );
        $resource = Source::create(array(
            "type" => "card"
        ));
        $this->assertSame("Stripe\\Source", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Source::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/sources/' . TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertSame("Stripe\\Source", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/sources/' . TEST_RESOURCE_ID
        );
        $resource = Source::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Source", get_class($resource));
    }

    public function testIsDetachable()
    {
        $resource = Source::retrieve(TEST_RESOURCE_ID);
        $resource->customer = "cus_123";
        $this->expectsRequest(
            'delete',
            '/v1/customers/cus_123/sources/' . TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertSame("Stripe\\Source", get_class($resource));
    }

    /*
    This does not yet work with our version of PHP Unit?
    public function testDetachErrors()
    {
        $resource = Source::retrieve(TEST_RESOURCE_ID);
        $this->expectException(Stripe\Error\Api::class);
        $resource->detach();
    }
    */

    public function testCanListSourceTransactions()
    {
        $source = Source::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'get',
            '/v1/sources/' . $source->id . "/source_transactions"
        );
        $resources = $source->sourceTransactions();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\SourceTransaction", get_class($resources->data[0]));
    }

    public function testCanVerify()
    {
        $resource = Source::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/sources/' . TEST_RESOURCE_ID . "/verify"
        );
        $resource->verify(array("values" => array(32,45)));
        $this->assertSame("Stripe\\Source", get_class($resource));
    }
}
