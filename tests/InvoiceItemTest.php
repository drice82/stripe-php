<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'ii_123');

class InvoiceItemTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/invoiceitems'
        );
        $resources = InvoiceItem::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\InvoiceItem", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/invoiceitems/' . TEST_RESOURCE_ID
        );
        $resource = InvoiceItem::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\InvoiceItem", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/invoiceitems'
        );
        $resource = InvoiceItem::create(array(
            "amount" => 100,
            "currency" => "usd",
            "customer" => "cus_123"
        ));
        $this->assertSame("Stripe\\InvoiceItem", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = InvoiceItem::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/invoiceitems/' . $resource->id
        );
        $resource->save();
        $this->assertSame("Stripe\\InvoiceItem", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/invoiceitems/' . TEST_RESOURCE_ID
        );
        $resource = InvoiceItem::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\InvoiceItem", get_class($resource));
    }

    public function testIsDeletable()
    {
        $invoiceItem = InvoiceItem::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/invoiceitems/' . $invoiceItem->id
        );
        $resource = $invoiceItem->delete();
        $this->assertSame("Stripe\\InvoiceItem", get_class($resource));
    }
}
