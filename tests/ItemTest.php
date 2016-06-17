<?php

namespace Omnipay\EpsomAdelante;

use Omnipay\Tests\TestCase;

class ItemTest extends TestCase
{
    public function setUp()
    {
        $this->item = new Item;
    }

    public function testFundCode()
    {
        $this->item->setFundCode('123');
        $this->assertSame('123', $this->item->getFundCode());
    }

    public function testCustRef1()
    {
        $this->item->setCustRef1('Test item');
        $this->assertSame('Test item', $this->item->getCustRef1());
    }

    public function testCustRef2()
    {
        $this->item->setCustRef2('Test item');
        $this->assertSame('Test item', $this->item->getCustRef2());
    }

    public function testCustRef3()
    {
        $this->item->setCustRef3('Test item');
        $this->assertSame('Test item', $this->item->getCustRef3());
    }

    public function testCustRef4()
    {
        $this->item->setCustRef4('Test item');
        $this->assertSame('Test item', $this->item->getCustRef4());
    }

    public function testPrice()
    {
        $this->item->setPrice('10.01');
        $this->assertSame(1001, $this->item->getPrice());
        $this->item->setPrice(10.02);
        $this->assertSame(1002, $this->item->getPrice());
        $this->item->setPrice('1003');
        $this->assertSame(1003, $this->item->getPrice());
    }
}
