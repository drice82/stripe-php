<?php

namespace Stripe;

class AccountOAuthTest extends TestCase
{
    public function testDeauthorize()
    {
        Stripe::setClientId('ca_test');

        $accountId = 'acct_test_deauth';
        $mockAccount = array(
            'id' => $accountId,
            'object' => 'account',
        );

        $this->mockRequest('GET', "/v1/accounts/$accountId", array(), $mockAccount);

        $this->mockRequest(
            'POST',
            '/oauth/deauthorize',
            array(
                'client_id' => 'ca_test',
                'stripe_user_id' => $accountId,
            ),
            array(
                'stripe_user_id' => $accountId,
            ),
            200,
            Stripe::$connectBase
        );

        $account = Account::retrieve($accountId);
        $account->deauthorize();

        Stripe::setClientId(null);
    }
}
