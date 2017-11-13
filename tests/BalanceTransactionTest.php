<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'txn_123');

class BalanceTransactionTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/balance/history'
        );
        $resources = BalanceTransaction::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\BalanceTransaction", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/balance/history/' . TEST_RESOURCE_ID
        );
        $resource = BalanceTransaction::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\BalanceTransaction", get_class($resource));
    }
}
