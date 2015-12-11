<?php

namespace Omnipay\EpsomAdelante\Message;

/**
 * Epsom connector to Adelante Purchase Request
 */
class PurchaseRequest extends AbstractRequest
{
    public function getChannel()
    {
        return $this->getParameter('channel');
    }

    public function setChannel($value)
    {
        return $this->setParameter('channel', $value);
    }

    public function getSessionId()
    {
        return $this->getTransactionId();
    }
    
    public function setSessionId($value)
    {
        return $this->setTransactionId($value);
    }

    /**
     * Override the abstract method to add length requirements
     *
     * Max 12 alphanum if used normally [auto appends _nnnnnnn], if CALLERID enabled on channel, 20 chars
     * No way to query CALLERID, so restricting to 20 instead of 12
     *
     * @param string|int $value The transaction ID (sessionid) to set for the transaction
     */
    public function setTransactionId($value)
    {
        return parent::setTransactionId(substr($value, 0, 20));
    }

    public function getFundCode()
    {
        return $this->getParameter('fundCode');
    }

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

    public function getTestEndpoint()
    {
        return $this->getParameter('testEndpoint');
    }

    public function setTestEndpoint($value)
    {
        return $this->setParameter('testEndpoint', $value);
    }

    public function getLiveEndpoint()
    {
        return $this->getParameter('liveEndpoint');
    }

    public function setLiveEndpoint($value)
    {
        return $this->setParameter('liveEndpoint', $value);
    }

    public function getData()
    {
        $this->validate('channel', 'transactionId', 'returnUrl');
        if ($this->getTestMode()) {
            $this->validate('testEndpoint');
        } else {
            $this->validate('liveEndpoint');
        }

        $data = array(
            // mandatory fields
            'channel'      => $this->getChannel(),
            'sessionid'    => $this->getSessionId(),
            'returnurl'    => $this->getReturnUrl(),
            // optional fields
            'returnmethod' => $this->getReturnMethod(),
            'sendMail'     => $this->getSendMail(),
        );

        // get and merge customer data
        $card = $this->getCard();
        if ($card) {
            $data += [
                'cfname'    => $card->getFirstName(),
                'csname'    => $card->getLastName(),
                'chouse'    => $card->getAddress1(), // @todo "house name or number"
                'cadd1'     => $card->getAddress2(), // @todo "street/road"
                'ctown'     => $card->getCity(),
                'cpostcode' => $card->getPostcode(),
                'ccountry'  => $card->getCountry(),
                'ctel'      => $card->getPhone(),
                'cemail'    => $card->getEmail(),
            ];
        }

        // get and merge line item data
        $items = $this->getItems();
        $fundcode = $this->getFundCode();
        if (empty($items)) {
            $this->validate('amount', 'fundCode');
            $data += [
                'amount'   => $this->getAmountInteger(),
                'fundcode' => $fundcode,
                'custref1' => $this->getDescription(),
            ];
        } else {
            foreach ($items as $n => $item) {
                $suffix = $n > 0 ? '_a'.$n : '';

                $itemFundcode = $item->getFundCode();
                $itemCustref1 = $item->getCustRef1();
                $itemCustref2 = $item->getCustRef2();
                $itemCustref3 = $item->getCustRef3();
                $itemCustref4 = $item->getCustRef4();

                // amount, fundcode and custref1 are required
                $data += [
                    'amount'.$suffix      => $item->getQuantity() * $item->getPrice(),
                    'fundcode'.$suffix    => empty($itemFundcode) ? $fundcode : $itemFundcode,
                    'custref1'.$suffix    => empty($itemCustref1) ? $item->getName() : $itemCustref1,
                    'custref2'.$suffix    => empty($itemCustref2) ? '' : $itemCustref2,
                    'custref3'.$suffix    => empty($itemCustref3) ? '' : $itemCustref3,
                    'custref4'.$suffix    => empty($itemCustref4) ? '' : $itemCustref4,
                    'description'.$suffix => substr($item->getDescription(), 0, 255),
                ];
            }
        }

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->getTestEndpoint() : $this->getLiveEndpoint();
    }
}
