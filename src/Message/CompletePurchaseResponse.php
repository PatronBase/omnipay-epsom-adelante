<?php

namespace Omnipay\EpsomAdelante\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * Epsom connector to Adelante Complete Purchase Response
 *
 * @todo Add more invalid response checks to the constructor for other fields dependent on 'errorstatus'
 */
class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     *
     * @throws InvalidResponseException If error status is missing
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);

        if (!isset($data['errorstatus']) || '' === $data['errorstatus']) {
            throw new InvalidResponseException('Invalid response from payment gateway');
        }
    }

    /**
     * Is the response an error?
     *
     * @return boolean
     */
    protected function isError()
    {
        return empty($this->data['errorstatus']);
    }

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return !$this->isError() && !empty($this->data['authstatus']);
    }

    /**
     * Get the authorisation code if available.
     *
     * @return null|string
     */
    public function getTransactionReference()
    {
        return isset($this->data['authcode']) ? $this->data['authcode'] : null;
    }

    /**
     * {@inheritDoc}
     */
    public function getTransactionId()
    {
        return isset($this->data['iasorderno']) ? $this->data['iasorderno'] : null;
    }

    /**
     * Get the merchant response message if available.
     *
     * @return null|string
     */
    public function getMessage()
    {
        if ($this->isError()) {
            if (!empty($this->data['errordescription'])) {
                return $this->data['errordescription'];
            }
            if (!empty($this->data['errorcode'])) {
                return $this->data['errorcode'];
            }
        }

        return null;
    }

    /**
     * Get the card type used if available.
     *
     * @return null|string
     */
    public function getCardType()
    {
        return isset($this->data['cardtype']) ? $this->data['cardtype'] : null;
    }

    /**
     * Get the amount paid in the transaction if available.
     *
     * The amount paid if given is the integer value in pence e.g. '1000' for £10.00
     *
     * @return null|string The floating point value
     */
    public function getAmountPaid()
    {
        return isset($this->data['amountpaid']) ? number_format($this->data['amountpaid'] / 100, 2) : null;
    }
}
