<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'si_123');

class SubscriptionItemItemTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/subscription_items'
        );
        $resources = SubscriptionItem::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\SubscriptionItem", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/subscription_items/' . TEST_RESOURCE_ID
        );
        $resource = SubscriptionItem::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\SubscriptionItem", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/subscription_items'
        );
        $resource = SubscriptionItem::create(array(
            "plan" => "plan",
            "subscription" => "sub_123"
        ));
        $this->assertSame("Stripe\\SubscriptionItem", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = SubscriptionItem::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/subscription_items/' . $resource->id
        );
        $resource->save();
        $this->assertSame("Stripe\\SubscriptionItem", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/subscription_items/' . TEST_RESOURCE_ID
        );
        $resource = SubscriptionItem::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\SubscriptionItem", get_class($resource));
    }

    public function testIsDeletable()
    {
        $resource = SubscriptionItem::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/subscription_items/' . $resource->id
        );
        $resource->delete();
        $this->assertSame("Stripe\\SubscriptionItem", get_class($resource));
    }
}
