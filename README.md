# IP tools

IP tools in PHP

![tests](https://github.com/MilesChou/ip/workflows/tests/badge.svg)
[![codecov](https://codecov.io/gh/MilesChou/ip/branch/master/graph/badge.svg)](https://app.codecov.io/gh/MilesChou/ip)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/f48768f96f1648adabebe0e9227170e4)](https://www.codacy.com/gh/MilesChou/ip/dashboard)
[![Latest Stable Version](https://poser.pugx.org/MilesChou/ip/v/stable)](https://packagist.org/packages/MilesChou/ip)
[![Total Downloads](https://poser.pugx.org/MilesChou/ip/d/total.svg)](https://packagist.org/packages/MilesChou/ip)
[![License](https://poser.pugx.org/MilesChou/ip/license)](https://packagist.org/packages/MilesChou/ip)


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
