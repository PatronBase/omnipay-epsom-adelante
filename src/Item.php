<?php
namespace Omnipay\EpsomAdelante;

use Omnipay\Common\Item as BaseItem;

class Item extends BaseItem
{
    /**
     * Fund code of the item
     */
    public function getFundCode()
    {
        return $this->getParameter('fundCode');
    }

    /**
     * Set the item fund code
     */
    public function setFundCode($value)
    {
        return $this->setParameter('fundCode', $value);
    }

    /**
     * Custom reference 1 of the item
     */
    public function getCustRef1()
    {
        return $this->getParameter('custRef1');
    }

    /**
     * Set the item custom reference 1
     */
    public function setCustRef1($value)
    {
        return $this->setParameter('custRef1', $value);
    }

    /**
     * Custom reference 2 of the item
     */
    public function getCustRef2()
    {
        return $this->getParameter('custRef2');
    }

    /**
     * Set the item custom reference 2
     */
    public function setCustRef2($value)
    {
        return $this->setParameter('custRef2', $value);
    }

    /**
     * Custom reference 3 of the item
     */
    public function getCustRef3()
    {
        return $this->getParameter('custRef3');
    }

    /**
     * Set the item custom reference 3
     */
    public function setCustRef3($value)
    {
        return $this->setParameter('custRef3', $value);
    }

    /**
     * Custom reference 4 of the item
     */
    public function getCustRef4()
    {
        return $this->getParameter('custRef4');
    }

    /**
     * Set the item custom reference 4
     */
    public function setCustRef4($value)
    {
        return $this->setParameter('custRef4', $value);
    }

    /**
     * {@inheritDoc}
     *
     * In addition, enforces price is integer value
     */
    public function setPrice($value)
    {
        // @todo would be nicer if this could be done with AbstractRequest currency functions (or similar)
        if (is_float($value) || (is_string($value) && strpos($value, '.') !== false)) {
            $value = (int) round($value * 100);
        }

        return parent::setPrice($value);
    }
}
