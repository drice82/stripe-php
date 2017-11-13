<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'fee_123');
define('TEST_FEEREFUND_ID', 'fr_123');

class ApplicationFeeTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/application_fees'
        );
        $resources = ApplicationFee::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\ApplicationFee", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/application_fees/' . TEST_RESOURCE_ID
        );
        $resource = ApplicationFee::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\ApplicationFee", get_class($resource));
    }

    public function testCanCreateRefund()
    {
        $this->expectsRequest(
            'post',
            '/v1/application_fees/' . TEST_RESOURCE_ID . '/refunds'
        );
        $resource = ApplicationFee::createRefund(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\ApplicationFeeRefund", get_class($resource));
    }

    public function testCanRetrieveRefund()
    {
        $this->expectsRequest(
            'get',
            '/v1/application_fees/' . TEST_RESOURCE_ID . '/refunds/' . TEST_FEEREFUND_ID
        );
        $resource = ApplicationFee::retrieveRefund(TEST_RESOURCE_ID, TEST_FEEREFUND_ID);
        $this->assertSame("Stripe\\ApplicationFeeRefund", get_class($resource));
    }

    public function testCanUpdateRefund()
    {
        $this->expectsRequest(
            'post',
            '/v1/application_fees/' . TEST_RESOURCE_ID . '/refunds/' . TEST_FEEREFUND_ID
        );
        $resource = ApplicationFee::updateRefund(TEST_RESOURCE_ID, TEST_FEEREFUND_ID);
        $this->assertSame("Stripe\\ApplicationFeeRefund", get_class($resource));
    }

    public function testCanListRefunds()
    {
        $this->expectsRequest(
            'get',
            '/v1/application_fees/' . TEST_RESOURCE_ID . '/refunds'
        );
        $resources = ApplicationFee::allRefunds(TEST_RESOURCE_ID);
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\ApplicationFeeRefund", get_class($resources->data[0]));
    }
}
