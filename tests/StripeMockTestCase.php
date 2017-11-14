<?php

namespace Stripe;

/**
 * Base class for stripe-mock based test cases.
 */
class StripeMockTestCase extends \PHPUnit_Framework_TestCase
{
    protected $origApiBase;
    protected $origApiKey;

    protected $mock;

    protected function setUp()
    {
        $this->origApiBase = Stripe::$apiBase;
        $this->origApiKey = Stripe::getApiKey();
        $this->origClientId = Stripe::getClientId();

        $this->mock = $this->getMock('\Stripe\HttpClient\ClientInterface');

        Stripe::$apiBase = "http://localhost:" . MOCK_PORT;
        Stripe::setApiKey("sk_test_123");
        Stripe::setClientId("ca_123");

        ApiRequestor::setHttpClient(HttpClient\CurlClient::instance());
    }

    protected function tearDown()
    {
        Stripe::$apiBase = $this->origApiBase;
        Stripe::setApiKey($this->origApiKey);
        Stripe::setClientId($this->origClientId);
    }

    protected function expectsRequest($method, $path, $params = null, $headers = null)
    {
        ApiRequestor::setHttpClient($this->mock);

        $absUrl = Stripe::$apiBase . $path;

        $this->mock
             ->expects($this->once())
             ->method('request')
             ->with(
                 $this->identicalTo(strtolower($method)),
                 $this->identicalTo($absUrl),
                 $headers === null ? $this->anything() : $this->identicalTo($headers),
                 $params === null ? $this->anything() : $this->identicalTo($params),
                 false
             )
             ->will($this->returnCallback("\\Stripe\\StripeMockTestCase::mockCallback"));
    }

    public static function mockCallback($method, $absUrl, $headers, $params, $hasFile)
    {
        $curlClient = HttpClient\CurlClient::instance();
        ApiRequestor::setHttpClient($curlClient);
        return $curlClient->request($method, $absUrl, $headers, $params, $hasFile);
    }

    protected function stubRequest($method, $path, $params = null, $response = array(), $base = null)
    {
        ApiRequestor::setHttpClient($this->mock);

        if ($base === null) {
            $base = Stripe::$apiBase;
        }
        $absUrl = $base . $path;

        $this->mock
             ->expects($this->once())
             ->method('request')
             ->with(
                 $this->identicalTo(strtolower($method)),
                 $this->identicalTo($absUrl),
                 $this->anything(),
                 $params === null ? $this->anything() : $this->identicalTo($params),
                 false
             )
             ->willReturn(array(json_encode($response), 200, array()));
    }
}
