<?php

namespace Stripe;

class CouponTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/coupons'
        );
        $coupons = Coupon::all();
        $this->assertTrue(is_array($coupons->data));
        $this->assertSame("Stripe\\Coupon", get_class($coupons->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/coupons/250FF'
        );
        $coupon = Coupon::retrieve("250FF");
        $this->assertSame("Stripe\\Coupon", get_class($coupon));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/coupons'
        );
        $coupon = Coupon::create(array(
            "percent_off" => 25,
            "duration" => "repeating",
            "duration_in_months" => 3,
            "id" => "250FF",
        ));
        $this->assertSame("Stripe\\Coupon", get_class($coupon));
    }

    public function testIsSaveable()
    {
        $coupon = Coupon::retrieve("250FF");
        $coupon->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/coupons/250FF'
        );
        $coupon->save();
        $this->assertSame("Stripe\\Coupon", get_class($coupon));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/coupons/250FF'
        );
        $coupon = Coupon::update("250FF", array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Coupon", get_class($coupon));
    }

    public function testIsDeletable()
    {
        $coupon = Coupon::retrieve("250FF");
        $this->expectsRequest(
            'delete',
            '/v1/coupons/250FF'
        );
        $coupon->delete();
        $this->assertSame("Stripe\\Coupon", get_class($coupon));
    }
}
