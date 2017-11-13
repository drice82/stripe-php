<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'apwc_123');

class ApplePayDomainTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/apple_pay/domains'
        );
        $resources = ApplePayDomain::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\ApplePayDomain", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/apple_pay/domains/' . TEST_RESOURCE_ID
        );
        $resource = ApplePayDomain::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\ApplePayDomain", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/apple_pay/domains'
        );
        $resource = ApplePayDomain::create(array(
            "domain_name" => "domain",
        ));
        $this->assertSame("Stripe\\ApplePayDomain", get_class($resource));
    }

    public function testIsDeletable()
    {
        $resource = ApplePayDomain::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/apple_pay/domains/' . TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertSame("Stripe\\ApplePayDomain", get_class($resource));
    }
}
