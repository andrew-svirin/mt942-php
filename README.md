# MT942-PHP
This tools convert MT942 formatted text to PHP objects. PHP library for parse MT942 format that uses Swift.  
Banks uses MT942 format for payments data transition.  
More details about MT942 format you can find in Internet.

Helper for [EBICS Client PHP](https://github.com/andrew-svirin/ebics-client-php)

### Installation
```bash
$ composer require andrew-svirin/mt942-php
```

### License
andrew-svirin/mt942-php is licensed under the MIT License, see the LICENSE file for details

### Example
Normalize:
```php
 $str = file_get_contents('path_to_file.mt942');
 $normalizer = new AndrewSvirin\MT942\MT942Normalizer();
 $transactionList = $normalizer->normalize($str);
```
Validate:
```php      
 $validator = new MT942Validator();
 $violationList = $validator->validateList($transactionList);
```

### Statistic
[![Build Status](https://travis-ci.org/andrew-svirin/mt942-php.svg?branch=master)](https://travis-ci.com/andrew-svirin/mt942-php)
