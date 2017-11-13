<?php

namespace Stripe;

define('TEST_RESOURCE_ID', 'acct_123');
define('TEST_EXTERNALACCOUNT_ID', 'ba_123');

class AccountTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/v1/accounts'
        );
        $resources = Account::all();
        $this->assertTrue(is_array($resources->data));
        $this->assertSame("Stripe\\Account", get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/v1/accounts/' . TEST_RESOURCE_ID
        );
        $resource = Account::retrieve(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\Account", get_class($resource));
    }

    public function testIsRetrievableWithoutId()
    {
        $this->expectsRequest(
            'get',
            '/v1/account'
        );
        $resource = Account::retrieve();
        $this->assertSame("Stripe\\Account", get_class($resource));
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts'
        );
        $resource = Account::create(array("type" => "custom"));
        $this->assertSame("Stripe\\Account", get_class($resource));
    }

    public function testIsSaveable()
    {
        $resource = Account::retrieve(TEST_RESOURCE_ID);
        $resource->metadata["key"] = "value";
        $this->expectsRequest(
            'post',
            '/v1/accounts/' . TEST_RESOURCE_ID
        );
        $resource->save();
        $this->assertSame("Stripe\\Account", get_class($resource));
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts/' . TEST_RESOURCE_ID
        );
        $resource = Account::update(TEST_RESOURCE_ID, array(
            "metadata" => array("key" => "value"),
        ));
        $this->assertSame("Stripe\\Account", get_class($resource));
    }

    public function testIsDeletable()
    {
        $resource = Account::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/v1/accounts/' . TEST_RESOURCE_ID
        );
        $resource->delete();
        $this->assertSame("Stripe\\Account", get_class($resource));
    }

    public function testIsRejectable()
    {
        $account = Account::retrieve(TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/v1/accounts/' . $account->id . '/reject'
        );
        $resource = $account->reject(array("reason" => "fraud"));
        $this->assertSame("Stripe\\Account", get_class($resource));
        $this->assertSame($resource, $account);
    }

    public function testCanCreateExternalAccount()
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts/' . TEST_RESOURCE_ID . '/external_accounts'
        );
        $resource = Account::createExternalAccount(TEST_RESOURCE_ID, array("external_account" => "btok_123"));
        $this->assertSame("Stripe\\BankAccount", get_class($resource));
    }

    public function testCanRetrieveExternalAccount()
    {
        $this->expectsRequest(
            'get',
            '/v1/accounts/' . TEST_RESOURCE_ID . '/external_accounts/' . TEST_EXTERNALACCOUNT_ID
        );
        $resource = Account::retrieveExternalAccount(TEST_RESOURCE_ID, TEST_EXTERNALACCOUNT_ID);
        $this->assertSame("Stripe\\BankAccount", get_class($resource));
    }

    public function testCanUpdateExternalAccount()
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts/' . TEST_RESOURCE_ID . '/external_accounts/' . TEST_EXTERNALACCOUNT_ID
        );
        $resource = Account::updateExternalAccount(TEST_RESOURCE_ID, TEST_EXTERNALACCOUNT_ID, array("name" => "name"));
        $this->assertSame("Stripe\\BankAccount", get_class($resource));
    }

    public function testCanDeleteExternalAccount()
    {
        $this->expectsRequest(
            'delete',
            '/v1/accounts/' . TEST_RESOURCE_ID . '/external_accounts/' . TEST_EXTERNALACCOUNT_ID
        );
        $resource = Account::deleteExternalAccount(TEST_RESOURCE_ID, TEST_EXTERNALACCOUNT_ID);
        $this->assertSame("Stripe\\BankAccount", get_class($resource));
    }

    public function testCanListExternalAccounts()
    {
        $this->expectsRequest(
            'get',
            '/v1/accounts/' . TEST_RESOURCE_ID . '/external_accounts'
        );
        $resources = Account::allExternalAccounts(TEST_RESOURCE_ID);
        $this->assertTrue(is_array($resources->data));
    }

    public function testCanCreateLoginLink()
    {
        $this->expectsRequest(
            'post',
            '/v1/accounts/' . TEST_RESOURCE_ID . '/login_links'
        );
        $resource = Account::createLoginLink(TEST_RESOURCE_ID);
        $this->assertSame("Stripe\\LoginLink", get_class($resource));
    }
}
