# MT942-PHP
This tools convert MT942 formatted text to PHP objects. PHP library for parse MT942 format that uses Swift.
Banks uses MT942 format for payments data transition.
More details about MT942 format you can find in Internet.

### Installation
```bash
$ composer require andrew-swirin/mt942-php
```

### License
andrew-swirin/mt942-php is licensed under the MIT License, see the LICENSE file for details

### Example
Include
```php
 use AndrewSvirin\MT942\MT942Normalizer;
```
Normalize:
```php
 $str = file_get_contents('path_to_file.mt942');
 $normalizer = new MT942Normalizer();
 $transactionList = $normalizer->normalize($str);
```
Validate:
```php      
 $validator = new MT942Validator();
 $violationList = $validator->validateList($transactionList);
```

### Statistic
[![Build Status](https://travis-ci.org/andrew-svirin/mt942-php.svg?branch=master)](https://travis-ci.com/andrew-svirin/mt942-php)