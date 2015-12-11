<?php

namespace Omnipay\EpsomAdelante\Message;

use Omnipay\Tests\TestCase;

/**
 * Extension of base test class to add helpers
 */
abstract class MessageTestCase extends TestCase
{
    protected function runChecks($message, $checks)
    {
        $data = $message->getData();
        foreach ($checks as $key => $expected) {
            $this->assertSame($expected, $data[$key]);
        }
    }
}
