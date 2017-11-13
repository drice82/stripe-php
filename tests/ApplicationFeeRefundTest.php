<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'fr_123');
define('TEST_FEE_ID', 'fee_123');

class ApplicationFeeRefundTest extends StripeMockTestCase
{
    public function testIsSaveable()
    {
        $resource = ApplicationFee::retrieveRefund(TEST_FEE_ID, TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/application_fees/' . $resource->fee . '/refunds/' . $resource->id
        );
        $resource->save();
        $this->assertSame("Stripe\\ApplicationFeeRefund", get_class($resource));
    }
}
