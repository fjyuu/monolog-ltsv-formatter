# LTSV Formatter #

[![StyleCI](https://styleci.io/repos/48897113/shield)](https://styleci.io/repos/48897113)
[![Latest Stable Version](https://poser.pugx.org/hikaeme/monolog-ltsv-formatter/v/stable)](https://packagist.org/packages/hikaeme/monolog-ltsv-formatter)
[![Total Downloads](https://poser.pugx.org/hikaeme/monolog-ltsv-formatter/downloads)](https://packagist.org/packages/hikaeme/monolog-ltsv-formatter)
[![Latest Unstable Version](https://poser.pugx.org/hikaeme/monolog-ltsv-formatter/v/unstable)](https://packagist.org/packages/hikaeme/monolog-ltsv-formatter)
[![License](https://poser.pugx.org/hikaeme/monolog-ltsv-formatter/license)](https://packagist.org/packages/hikaeme/monolog-ltsv-formatter)

An [LTSV](http://ltsv.org/) Formatter for [Monolog](https://github.com/Seldaek/monolog)

## Usage ##

```php
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Hikaeme\Monolog\Formatter\LtsvFormatter;

$log = new Logger('DEMO');
$handler = new StreamHandler('php://stdout', Level::Error);
$handler->setFormatter(new LtsvFormatter('Y-m-d H:i:s'));
$log->pushHandler($handler);

$log->error('Something happened', ['detail1' => 'foo', 'detail2' => 'bar']);
// time:2016-01-02 11:58:03<tab>level:ERROR<tab>message:Something happened<tab>detail1:foo<tab>detail2:bar
```

## Installation ##

```
composer require hikaeme/monolog-ltsv-formatter
```
