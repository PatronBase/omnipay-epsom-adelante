<?php

namespace Omnipay\EpsomAdelante\Message;

class PurchaseRequestTest extends MessageTestCase
{
    /** @var PurchaseRequest */
    private $request;

    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'channel'       => 'ADELANTE',
                'sessionId'     => '123abc',
                'currency'      => 'GBP',
                'returnUrl'     => 'https://www.example.com/return',
                'returnMethod'  => 'post',
                'sendMail'      => 'n',
                'testendpoint'  => 'https://devpayments.epsom-ewell.gov.uk/TestPay/wsconn_pay.asp',
                'liveendpoint'  => 'https://payments.epsom-ewell.gov.uk/Pay/wsconn_pay.asp',

                'items' => array(
                    array(
                        'price'       => 1.45,
                        'quantity'    => 1,
                        'name'        => 'Test item 1',
                        'description' => '1 x test item 1',
                        'fundcode'    => '2',
                    ),
                ),

                'card' => array(
                    'firstName' => 'Fred',
                    'lastName'  => 'Jones',
                    'address1'  => '1 The Road',
                    'address2'  => '',
                    'city'      => 'Bigtown',
                    'postcode'  => 'TE57 1NG',
                    'state'     => '',
                    'country'   => 'United Kingdom',
                    'phone'     => '01234 5678901',
                    'email'     => 'me@my.place.com',
                ),
            )
        );
    }

    public function testGetData()
    {
        $this->runChecks($this->request, array(
            'channel'      => 'ADELANTE',
            'sessionid'    => '123abc',
            'returnurl'    => 'https://www.example.com/return',

            'amount'       => 145,
            'fundcode'     => '2',
            'custref1'     => 'Test item 1',
            'custref2'     => '',
            'custref3'     => '',
            'custref4'     => '',

            'cfname'       => 'Fred',
            'csname'       => 'Jones',
            'chouse'       => '1 The Road', // no practical way to auto-parse this correctly into chouse/cadd1
            'cadd1'        => '',
            'ctown'        => 'Bigtown',
            'cpostcode'    => 'TE57 1NG',
            'ccountry'     => 'United Kingdom',
            'ctel'         => '01234 5678901',
            'cemail'       => 'me@my.place.com',
        ));
    }

    public function testGetDataTestMode()
    {
        $this->request->setTestMode(true);
        $this->assertSame('https://devpayments.epsom-ewell.gov.uk/TestPay/wsconn_pay.asp', $this->request->getEndpoint());
        $this->request->setTestMode(false);
        $this->assertSame('https://payments.epsom-ewell.gov.uk/Pay/wsconn_pay.asp', $this->request->getEndpoint());
    }

    public function testSetSessionId()
    {
        $this->request->setSessionId('twelvechars1');
        $this->assertSame('twelvechars1', $this->request->getSessionId());
        $this->assertSame('twelvechars1', $this->request->getTransactionId());
        $this->request->setSessionId('morethantwentycharacters'); // truncates
        $this->assertSame('morethantwentycharac', $this->request->getSessionId());
        $this->assertSame('morethantwentycharac', $this->request->getTransactionId());
    }
}
