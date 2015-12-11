<?php

namespace Omnipay\EpsomAdelante\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\Common\ItemBag;
use Omnipay\EpsomAdelante\Item;

abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     * Set the items in this order
     *
     * @param ItemBag|array $items An array of items in this order
     * @return AbstractRequest
     */
    public function setItems($items)
    {
        if (!empty($items) && !$items instanceof ItemBag) {
            foreach ($items as &$item) {
                $item = new Item($item);
            }
        }

        parent::setItems($items);
    }
}
