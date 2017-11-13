<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'US');

class CountrySpecTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/country_specs'
        );
        $resources = CountrySpec::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\CountrySpec", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/country_specs/' . TEST_RESOURCE_ID
        );
        $resource = CountrySpec::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\CountrySpec", get_class($resource));
    }
}
