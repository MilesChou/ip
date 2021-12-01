# IP tools

IP tools in PHP

![tests](https://github.com/MilesChou/ip/workflows/tests/badge.svg)

## Installation

Install package by Composer:

```bash
composer require mileschou/ip
```

## Usage

This a simple collection to store IP list and can find IP in list.

```php

$collection = new V4();
$collection->addCidr('127.0.0.0/8');

$collection->has('127.0.0.1');      // true
$collection->has('192.168.0.1');    // false
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
