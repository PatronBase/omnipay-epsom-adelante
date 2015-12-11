<?php

namespace Omnipay\EpsomAdelante\Message;

class CompletePurchaseResponseTest extends MessageTestCase
{
    /** @var CompletePurchaseResponse */
    protected $response;

    public function testCompletePurchaseSuccess()
    {
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'sessionid' => '123abc',
                'errorstatus' => '1',
                'authstatus' => '1',
                'authcode' => '10',
                'errorcode' => '',
                'errordescription' => '',
                'iasorderno' => '987654',
                'cardtype' => 'VC',
                'amountpaid' => '2000',
            )
        );

        $this->assertTrue($this->response->isSuccessful());
        $this->assertFalse($this->response->isRedirect());
        $this->assertFalse($this->isError());
        $this->assertSame('10', $this->response->getTransactionReference());
        $this->assertSame('987654', $this->response->getTransactionId());
        $this->assertNull($this->response->getMessage());
        $this->assertSame('VC', $this->response->getCardType());
        $this->assertSame('20.00', $this->response->getAmountPaid());
    }

    public function testCompletePurchaseFailure()
    {
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'sessionid' => '123abc',
                'errorstatus' => '1',
                'authstatus' => '0',
                'authcode' => '99',
                'errorcode' => '',
                'errordescription' => '',
                'iasorderno' => '987654',
            )
        );

        $this->assertFalse($this->response->isSuccessful());
        $this->assertFalse($this->response->isRedirect());
        $this->assertFalse($this->isError());
        $this->assertSame('99', $this->response->getTransactionReference());
        $this->assertSame('987654', $this->response->getTransactionId());
        $this->assertNull($this->response->getMessage());
    }

    public function testCompletePurchaseError()
    {
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'sessionid' => '123abc',
                'errorstatus' => '0',
                'authstatus' => '',
                'authcode' => '',
                'errorcode' => '50',
                'errordescription' => '',
                'iasorderno' => '987654',
            )
        );

        $this->assertFalse($this->response->isSuccessful());
        $this->assertFalse($this->response->isRedirect());
        $this->assertTrue($this->isError());
        $this->assertSame('50', $this->response->getMessage());
        $this->assertSame('987654', $this->response->getTransactionId());
    }

    public function testCompletePurchaseErrorWithMessage()
    {
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'sessionid' => '123abc',
                'errorstatus' => '0',
                'authstatus' => '',
                'authcode' => '',
                'errorcode' => '50',
                'errordescription' => 'Something wrong',
                'iasorderno' => '987654',
            )
        );

        $this->assertFalse($this->response->isSuccessful());
        $this->assertFalse($this->response->isRedirect());
        $this->assertTrue($this->isError());
        $this->assertSame('Something wrong', $this->response->getMessage());
        $this->assertSame('987654', $this->response->getTransactionId());
    }

    public function testCompletePurchaseInvalidNoParameters()
    {
        $this->setExpectedException(
            'Omnipay\Common\Exception\InvalidResponseException',
            'Invalid response from payment gateway'
        );
        $this->response = new CompletePurchaseResponse(
            $this->getMockRequest(),
            array(
                'sessionid' => '',
                'errorstatus' => '',
                'authstatus' => '',
                'authcode' => '',
                'errorcode' => '',
                'errordescription' => '',
                'iasorderno' => '',
            )
        );
    }

    /**
     * Helper method to test protected isError() method
     */
    protected function isError()
    {
        $class = new \ReflectionClass($this->response);
        $method = $class->getMethod('isError');
        $method->setAccessible(true);

        return $method->invokeArgs($this->response, array());
    }
}
