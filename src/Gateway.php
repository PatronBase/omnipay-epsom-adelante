<?php

namespace Omnipay\EpsomAdelante;

use Omnipay\Common\AbstractGateway;
use Omnipay\EpsomAdelante\Message\CompletePurchaseRequest;
use Omnipay\EpsomAdelante\Message\PurchaseRequest;

/**
 * Epsom connector to Adelante Gateway
 *
 * @link http://www.adelante.co.uk/sell-online
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'EpsomAdelante';
    }

    /**
     * Get the default parameters
     *
     * channel : supplied by Adelante
     * returnMethod : either 'post' or 'redirect'; anything blank/invalid will result in 'post'
     * sendMail : 'y' if gateway sends receipt to user; blank/invalid (or if no email address supplied) means no email
     *
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'channel' => '',
            'fundCode' => '',
            'returnMethod' => 'post',
            'sendMail' => '',
            'testEndpoint' => '',
            'liveEndpoint' => '',
            'currency' => 'GBP',
            'testMode' => false,
        );
    }

    public function getChannel()
    {
        return $this->getParameter('channel');
    }

    public function setChannel($value)
    {
        return $this->setParameter('channel', $value);
    }

    /**
     * Default fund code if none supplied by the item
     */
    public function getFundCode()
    {
        return $this->getParameter('fundCode');
    }

    /**
     * Set the default fund code
     *
     * If this is left blank, or is unspecified a default fund code can be derived from the pre-set data selected by
     * the given channel code, but this is not enabled by default.
     */
    public function setFundCode($value)
    {
        return $this->setParameter('fundCode', $value);
    }

    public function getReturnMethod()
    {
        return $this->getParameter('returnMethod');
    }

    public function setReturnMethod($value)
    {
        return $this->setParameter('returnMethod', $value);
    }

    public function getSendMail()
    {
        return $this->getParameter('sendMail');
    }

    public function setSendMail($value)
    {
        return $this->setParameter('sendMail', $value);
    }

    /**
     * Payment connector interface test endpoint for specific customer
     */
    public function getTestEndpoint()
    {
        return $this->getParameter('testEndpoint');
    }

    public function setTestEndpoint($value)
    {
        return $this->setParameter('testEndpoint', $value);
    }

    /**
     * Payment connector interface live endpoint for specific customer
     */
    public function getLiveEndpoint()
    {
        return $this->getParameter('liveEndpoint');
    }

    public function setLiveEndpoint($value)
    {
        return $this->setParameter('liveEndpoint', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\EpsomAdelante\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\EpsomAdelante\Message\CompletePurchaseRequest', $parameters);
    }
}
