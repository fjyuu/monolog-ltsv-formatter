# LTSV Formatter #

[![Build Status](https://travis-ci.org/fjyuu/monolog-ltsv-formatter.svg?branch=master)](https://travis-ci.org/fjyuu/monolog-ltsv-formatter)
[![StyleCI](https://styleci.io/repos/48897113/shield)](https://styleci.io/repos/48897113)

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
