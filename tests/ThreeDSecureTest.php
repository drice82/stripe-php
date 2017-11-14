<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'tdsrc_123');

class ThreeDSecureTest extends StripeMockTestCase
{
    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/3d_secure/' . TEST_RESOURCE_ID
        );
        $resource = ThreeDSecure::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\ThreeDSecure", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/3d_secure'
        );
        $resource = ThreeDSecure::create(array(
            "amount" => 100,
            "currency" => "usd",
            "return_url" => "url"
        ));
        $this->assertSame("Stripe\\ThreeDSecure", get_class($resource));
    }
}
