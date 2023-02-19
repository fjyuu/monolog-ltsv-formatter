# LTSV Formatter #

A [LTSV](http://ltsv.org/) Formatter for [Monolog](https://github.com/Seldaek/monolog)

This is a fork project of https://github.com/fjyuu/monolog-ltsv-formatter

## Usage ##

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Tyamahori\Monolog\Formatter\LtsvFormatter;

$log = new Logger('DEMO');
$handler = new StreamHandler('php://stdout', Logger::WARNING);
$handler->setFormatter(new LtsvFormatter('Y-m-d H:i:s'));
$log->pushHandler($handler);

$log->error('Something happened', ['detail1' => 'foo', 'detail2' => 'bar']);
// time:2016-01-02 11:58:03<tab>level:ERROR<tab>message:Something happened<tab>detail1:foo<tab>detail2:bar
```

## Requirement
- PHP8.1 or later
- Monolog v3 or higher

## Installation
```
composer require tyamahori/monolog-ltsv-formatter
```
