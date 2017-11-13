<?php

namespace Stripe;

class BalanceTest extends StripeMockTestCase
{
    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/balance'
        );
        $resource = Balance::retrieve();
        $this->assertSame("Stripe\\Balance", get_class($resource));
    }
}
