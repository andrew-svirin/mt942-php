#MT942-PHP
This tools convert MT942 formatted text to PHP objects. PHP library for parse MT942 format that uses Swift.
Banks uses MT942 format for payments data transition.
More details about MT942 format you can find on page https://www.google.com/search?q=MT942

### How to install:
`composer require andrew-swirin/mt942-php`

### License
@license http://www.opensource.org/licenses/mit-license.html  MIT License

###Example:
Include
```
use AndrewSvirin\MT942;
```
Parse:
```
$result = MT942::fromString('...');
```
