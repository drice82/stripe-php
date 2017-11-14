<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'tr_123');
define('TEST_REVERSAL_ID', 'trr_123');

class TransferTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/transfers'
        );
        $resources = Transfer::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Transfer", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/transfers/' . TEST_RESOURCE_ID
        );
        $resource = Transfer::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Transfer", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/transfers'
        );
        $resource = Transfer::create(array(
            "amount" => 100,
            "currency" => "usd",
            "destination" => "acct_123"
        ));
        $this->assertSame("Stripe\\Transfer", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Transfer::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/transfers/' . $resource->id
        );
        $resource->save();
        $this->assertSame("Stripe\\Transfer", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/transfers/' . TEST_RESOURCE_ID
        );
        $resource = Transfer::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Transfer", get_class($resource));
    }

    public function testIsReversable()
    {
        $resource = Transfer::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/transfers/' . $resource->id . '/reversals'
        );
        $resource->reverse();
        $this->assertSame("Stripe\\Transfer", get_class($resource));
    }

    public function testIsCancelable()
    {
        $transfer = Transfer::retrieve(TEST_RESOURCE_ID);

        // stripe-mock does not support this anymore so we stub it
        $this->stubRequest(
            'post',
            '/v1/transfers/' . $transfer->id . '/cancel'
        );
        $resource = $transfer->cancel();
        $this->assertSame("Stripe\\Transfer", get_class($resource));
        $this->assertSame($resource, $transfer);
    }

    public function testCanCreateReversal()
    {
        $this->expectsRequest(
            'post',
            '/v1/transfers/' . TEST_RESOURCE_ID . '/reversals'
        );
        $resource = Transfer::createReversal(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\TransferReversal", get_class($resource));
    }

    public function testCanRetrieveReversal()
    {
        $this->expectsRequest(
            'get',
            '/v1/transfers/' . TEST_RESOURCE_ID . '/reversals/' . TEST_REVERSAL_ID
        );
        $resource = Transfer::retrieveReversal(TEST_RESOURCE_ID, TEST_REVERSAL_ID);
        $this->assertSame("Stripe\\TransferReversal", get_class($resource));
    }

    public function testCanUpdateReversal()
    {
        $this->expectsRequest(
            'post',
            '/v1/transfers/' . TEST_RESOURCE_ID . '/reversals/' . TEST_REVERSAL_ID
        );
        $resource = Transfer::updateReversal(
            TEST_RESOURCE_ID,
            TEST_REVERSAL_ID,
            array(
                "metadata" => array("key" => "value"),
            )
        );
        $this->assertSame("Stripe\\TransferReversal", get_class($resource));
    }

    public function testCanListReversal()
    {
        $this->expectsRequest(
            'get',
            '/v1/transfers/' . TEST_RESOURCE_ID . '/reversals'
        );
        $resources = Transfer::allReversals(TEST_RESOURCE_ID);
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\TransferReversal", get_class($resources->data[0]));
    }
}
