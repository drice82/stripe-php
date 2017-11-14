<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'trr_123');
define('TEST_TRANSFER_ID', 'tr_123');

class TransferreversalTest extends StripeMockTestCase
{
    public function testIsSaveable()
    {
        $resource = Transfer::retrieveReversal(TEST_TRANSFER_ID, TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/transfers/' . $resource->transfer . '/reversals/' . $resource->id
        );
        $resource->save();
        $this->assertSame("Stripe\\TransferReversal", get_class($resource));
    }
}
