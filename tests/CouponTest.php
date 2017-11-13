<?php

namespace Stripe;

define('TEST_RESOURCE_ID', '25OFF');

class CouponTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/coupons'
        );
        $resources = Coupon::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Coupon", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/coupons/' . TEST_RESOURCE_ID
        );
        $resource = Coupon::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Coupon", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/coupons'
        );
        $resource = Coupon::create(array(
            "percent_off" => 25,
            "duration" => "repeating",
            "duration_in_months" => 3,
            "id" => TEST_RESOURCE_ID,
        ));
        $this->assertSame("Stripe\\Coupon", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Coupon::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/coupons/' . TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertSame("Stripe\\Coupon", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/coupons/' . TEST_RESOURCE_ID
        );
        $resource = Coupon::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Coupon", get_class($resource));
    }

    public function testIsDeletable()
    {
        $resource = Coupon::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/coupons/' . TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertSame("Stripe\\Coupon", get_class($resource));
    }
}
