<?php

namespace Omnipay\EpsomAdelante;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount'       => '1.45',
            'currency'     => 'GBP',
            'channel'      => 'ADELANTE',
            'sessionId'    => '123abc',
            'fundCode'     => '2',
            'returnMethod' => 'post',
            'returnUrl'    => 'https://www.example.com/return',
            'testMode'     => true,
            'testendpoint' => 'https://devpayments.epsom-ewell.gov.uk/TestPay/wsconn_pay.asp',
            'liveendpoint' => 'https://payments.epsom-ewell.gov.uk/Pay/wsconn_pay.asp',
        );
    }

    public function testPurchase()
    {
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertEquals('https://devpayments.epsom-ewell.gov.uk/TestPay/wsconn_pay.asp', $response->getRedirectUrl());
    }

    public function testCompletePurchaseSuccess()
    {
        $this->getHttpRequest()->request->replace(
            array(
                'errorstatus' => 1,
                'authstatus'  => 1,
                'authcode'    => 1,
            )
        );

        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals('1', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }

    public function testCompletePurchaseFailure()
    {
        $this->getHttpRequest()->request->replace(
            array(
                'errorstatus' => 1,
                'authstatus'  => 0,
            )
        );

        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getMessage());
    }

    public function testCompletePurchaseError()
    {
        $this->getHttpRequest()->request->replace(
            array(
                'errorstatus' => 0,
                'errorcode'   => 0,
            )
        );

        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(0, (int) $response->getMessage());
    }

    public function testCompletePurchaseErrorWithDescription()
    {
        $this->getHttpRequest()->request->replace(
            array(
                'errorstatus'      => 0,
                'errorcode'        => 50,
                'errordescription' => 'Something went wrong',
            )
        );

        $response = $this->gateway->completePurchase($this->options)->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Something went wrong', $response->getMessage());
    }
}
