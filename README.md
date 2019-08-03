# MT942-PHP
This tools convert MT942 formatted text to PHP objects. PHP library for parse MT942 format that uses Swift.
Banks uses MT942 format for payments data transition.
More details about MT942 format you can find in Internet.

### How to install:
`composer require andrew-swirin/mt942-php`

### License
@license http://www.opensource.org/licenses/mit-license.html  MIT License

### Example:
Include
```
use AndrewSvirin\MT942\MT942Normalizer;
```
Normalize:
```
      $adapter = new MT942Normalizer();
      $str = file_get_contents('path_to_file.mt942');
      $transactions = $adapter->normalize($str);
```

[![Build Status](https://travis-ci.com/andrew-svirin/mt942-php.svg?branch=master)](https://travis-ci.com/andrew-svirin/mt942-php)