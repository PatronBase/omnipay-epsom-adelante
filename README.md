# Omnipay: Epsom connector to Adelante

**Epsom connector to Adelante (ConnectPay) driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/PatronBase/omnipay-epsom-adelante.png?branch=master)](https://travis-ci.org/PatronBase/omnipay-epsom-adelante)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/PatronBase/omnipay-epsom-adelante.svg?style=flat)](https://scrutinizer-ci.com/g/PatronBase/omnipay-epsom-adelante/code-structure)
[![Code Quality](https://img.shields.io/scrutinizer/g/PatronBase/omnipay-epsom-adelante.svg?style=flat)](https://scrutinizer-ci.com/g/PatronBase/omnipay-epsom-adelante/?branch=master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)
[![Latest Stable Version](https://poser.pugx.org/PatronBase/omnipay-epsom-adelante/version.png)](https://packagist.org/packages/patronbase/omnipay-epsom-adelante)
[![Total Downloads](https://poser.pugx.org/patronbase/omnipay-epsom-adelante/d/total.png)](https://packagist.org/packages/patronbase/omnipay-epsom-adelante)


[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Epsom's connector to Adelante (ConnectPay) support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "PatronBase/omnipay-epsom-adelante": "~2.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Epsom connector to Adelante (ConnectPay)

*Note:* this connects to the customer-specific connector interface and will require setting the test/live endpoints,
rather than talking to ConnectPay gateway directly which has a different API.

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/PatronBase/omnipay-epsom-adelante/issues),
or better yet, fork the library and submit a pull request.
