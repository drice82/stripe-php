<?php

namespace Stripe;

class SourceTransactionTest extends StripeMockTestCase
{
    public function testIsListable()
    {
        $source = \Stripe\Source::constructFrom(
            array('id' => 'src_foo', 'object' => 'source'),
            new \Stripe\Util\RequestOptions()
        );

        $this->stubRequest(
            'get',
            '/v1/sources/src_foo/source_transactions',
            array(),
            array(
                'object' => 'list',
                'url' => '/v1/sources/src_foo/source_transactions',
                'data' => array(
                    array(
                        'id' => 'srctxn_bar',
                        'object' => 'source_transaction',
                    ),
                ),
                'has_more' => false,
            )
        );
        $transactions = $source->sourceTransactions();

        $this->assertTrue(is_array($transactions->data));
        $this->assertSame('Stripe\\SourceTransaction', get_class($transactions->data[0]));
    }
}
