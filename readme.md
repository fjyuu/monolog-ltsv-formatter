# LTSV Formatter #

[![Build Status](https://travis-ci.org/fjyuu/monolog-ltsv-formatter.svg?branch=master)](https://travis-ci.org/fjyuu/monolog-ltsv-formatter)
[![StyleCI](https://styleci.io/repos/48897113/shield)](https://styleci.io/repos/48897113)
[![Test Coverage](https://codeclimate.com/github/fjyuu/monolog-ltsv-formatter/badges/coverage.svg)](https://codeclimate.com/github/fjyuu/monolog-ltsv-formatter/coverage)
[![Latest Stable Version](https://poser.pugx.org/hikaeme/monolog-ltsv-formatter/v/stable)](https://packagist.org/packages/hikaeme/monolog-ltsv-formatter)
[![Total Downloads](https://poser.pugx.org/hikaeme/monolog-ltsv-formatter/downloads)](https://packagist.org/packages/hikaeme/monolog-ltsv-formatter)
[![Latest Unstable Version](https://poser.pugx.org/hikaeme/monolog-ltsv-formatter/v/unstable)](https://packagist.org/packages/hikaeme/monolog-ltsv-formatter)
[![License](https://poser.pugx.org/hikaeme/monolog-ltsv-formatter/license)](https://packagist.org/packages/hikaeme/monolog-ltsv-formatter)

A [LTSV](http://ltsv.org/) Formatter for [Monolog](https://github.com/Seldaek/monolog)

## Usage ##

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Hikaeme\Monolog\Formatter\LtsvFormatter;

$log = new Logger('DEMO');
$handler = new StreamHandler('php://stdout', Logger::WARNING);
$handler->setFormatter(new LtsvFormatter());
$log->pushHandler($handler);

$log->addError('Something happened', array('detail1' => 'foo', 'detail2' => 'bar'));
// time:2016-01-02 11:58:03<tab>level:ERROR<tab>message:Something happened<tab>detail1:foo<tab>detail2:bar
```

## Installation ##

```
composer require hikaeme/monolog-ltsv-formatter
```
