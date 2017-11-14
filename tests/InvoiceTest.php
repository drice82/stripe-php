<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'in_123');

class InvoiceTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/invoices'
        );
        $resources = Invoice::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Invoice", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/invoices/' . TEST_RESOURCE_ID
        );
        $resource = Invoice::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Invoice", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/invoices'
        );
        $resource = Invoice::create(array(
            "customer" => "cus_123"
        ));
        $this->assertSame("Stripe\\Invoice", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Invoice::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/invoices/' . TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertSame("Stripe\\Invoice", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/invoices/' . TEST_RESOURCE_ID
        );
        $resource = Invoice::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Invoice", get_class($resource));
    }

    public function testCanRetrieveUpcoming()
    {
        $this->expectsRequest(
            'get',
            '/v1/invoices/upcoming'
        );
        $resource = Invoice::upcoming(array("customer" => "cus_123"));
        $this->assertSame("Stripe\\Invoice", get_class($resource));
    }

    public function testIsPayable()
    {
        $invoice = Invoice::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/invoices/' . $invoice->id . '/pay'
        );
        $resource = $invoice->pay();
        $this->assertSame("Stripe\\Invoice", get_class($resource));
        $this->assertSame($resource, $invoice);
    }
}
