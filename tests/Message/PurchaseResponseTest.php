<?php

namespace Omnipay\EpsomAdelante\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends MessageTestCase
{
    /** @var PurchaseResponse */
    private $response;

    public function setUp()
    {
        $this->response = new PurchaseResponse($this->getMockRequest(), array(
            'channel'   => 'ADELANTE',
            'sessionid' => '123abc',
            'returnurl' => 'https://www.example.com/return',

            'amount'    => 145,
            'fundcode'  => '2',
            'custref1'  => 'Test item 1',
            'custref2'  => '145',
            'custref3'  => '1',
            'custref4'  => '',

            'cfname'    => 'Fred',
            'csname'    => 'Jones',
            'chouse'    => '1',
            'cadd1'     => 'The Road',
            'ctown'     => 'Bigtown',
            'cpostcode' => 'TE57 1NG',
            'ccountry'  => 'United Kingdom',
            'ctel'      => '01234 5678901',
            'cemail'    => 'me@my.place.com',
        ));
    }

    public function testPurchaseSuccess()
    {
        $this->getMockRequest()
            ->shouldReceive('getEndpoint')->once()
            ->andReturn('https://devpayments.epsom-ewell.gov.uk/TestPay/wsconn_pay.asp');

        $this->assertFalse($this->response->isSuccessful());
        $this->assertTrue($this->response->isRedirect());
        $this->assertSame('https://devpayments.epsom-ewell.gov.uk/TestPay/wsconn_pay.asp', $this->response->getRedirectUrl());
        $this->assertSame('POST', $this->response->getRedirectMethod());
        $this->assertSame(
            array(
                'channel'   => 'ADELANTE',
                'sessionid' => '123abc',
                'returnurl' => 'https://www.example.com/return',

                'amount'    => 145,
                'fundcode'  => '2',
                'custref1'  => 'Test item 1',
                'custref2'  => '145',
                'custref3'  => '1',
                'custref4'  => '',

                'cfname'    => 'Fred',
                'csname'    => 'Jones',
                'chouse'    => '1',
                'cadd1'     => 'The Road',
                'ctown'     => 'Bigtown',
                'cpostcode' => 'TE57 1NG',
                'ccountry'  => 'United Kingdom',
                'ctel'      => '01234 5678901',
                'cemail'    => 'me@my.place.com',
            ),
            $this->response->getRedirectData()
        );
        $this->assertNull($this->response->getTransactionReference());
        $this->assertNull($this->response->getMessage());
    }
}
