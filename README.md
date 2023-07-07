# PHP Date Parser

This library parses different strings to DateTime or DateTimeImmutable classes.

## Installation

```bash
composer require ixnode/php-date-parser
```

```bash
vendor/bin/php-date-parser -V
```

```bash
php-date-parser 0.1.0 (07-07-2023 22:23:01) - Björn Hempel <bjoern@hempel.li>
```

## Usage

```php
use Ixnode\PhpDateParser\DateParser;
```

### Date parser

```php
$dateParser = (new DateParser('<2023-07-01'))->formatFrom('Y-m-d H:i:s');
// null

$dateParser = (new DateParser('<2023-07-01'))->formatTo('Y-m-d H:i:s');
// 2023-06-30 23:59:59
```

### Word parser

```php
$dateParser = (new DateParser('today'))->formatFrom('Y-m-d H:i:s');
// 2023-07-07 00:00:00

$dateParser = (new DateParser('today'))->formatTo('Y-m-d H:i:s');
// 2023-07-07 23:59:59
```

## Parsing formats / overview

*  Imagine today would be the `2023-07-07`

| string                                  | description                                           | from                                 | to                                   |
|-----------------------------------------|-------------------------------------------------------|--------------------------------------|--------------------------------------|
| <nobr>`"today"`</nobr>                  | Returns the date range from today.                    | <nobr>`"2023-07-07 00:00:00"`</nobr> | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"yesterday"`</nobr>              | Returns the date range from yesterday.                | <nobr>`"2023-07-06 00:00:00"`</nobr> | <nobr>`"2023-07-06 23:59:59"`</nobr> |
| <nobr>`"2023-07-01"`</nobr>             | Exactly the given date.                               | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-01 23:59:59"`</nobr> |
| <nobr>`"<2023-07-01"`</nobr>            | Lower than the given date (excluding the given one).  | <nobr>`NULL`</nobr>                  | <nobr>`"2023-06-30 23:59:59"`</nobr> |
| <nobr>`"<+2023-07-01"`</nobr>           | Lower than the given date (including the given one).  | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-01 23:59:59"`</nobr> |
| <nobr>`">2023-07-01"`</nobr>            | Higher than the given date (excluding the given one). | <nobr>`"2023-07-02 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">+2023-07-01"`</nobr>           | Higher than the given date (including the given one). | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`"+2023-07-01"`</nobr>            | Alias of `">+2023-07-01"`                             | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`"2023-07-01\|2023-07-03"`</nobr> | Date from `"2023-07-01"` to `"2023-07-03"`            | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-03 23:59:59"`</nobr> |
| <nobr>`"2023-07-01\|today"`</nobr>      | Date from `"2023-07-01"` to `"today"`                 | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"2023-07-01\|yesterday"`</nobr>  | Date from `"2023-07-01"` to `"yesterday"`             | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-06 23:59:59"`</nobr> |
| <nobr>`"yesterday\|today"`</nobr>       | Date from `"yesterday"` to `"today"`                  | <nobr>`"2023-07-06 00:00:00"`</nobr> | <nobr>`"2023-07-07 23:59:59"`</nobr> |

## Methods

### Class `DateParser`

| method                               | description                                            | type                      |
|--------------------------------------|--------------------------------------------------------|---------------------------|
| <nobr>`->formatFrom($format)`</nobr> | Returns the formatted "from" date.                     | `string`                  |
| <nobr>`->formatTo($format)`</nobr>   | Returns the formatted "to" date.                       | `string`                  |
| <nobr>`->getDateRange()`</nobr>      | Returns the range as `DateRange` class.                | `DateRange`               |
| <nobr>`->getFrom()`</nobr>           | Returns the "from" date as `DateTime` object.          | `DateTime\|null`          |
| <nobr>`->getTo()`</nobr>             | Returns the "to" date as `DateTime` object.            | `DateTime\|null`          |
| <nobr>`->getFromImmutable()`</nobr>  | Returns the "from" date as `DateTimeImmutable` object. | `DateTimeImmutable\|null` |
| <nobr>`->getToImmutable()`</nobr>    | Returns the "to" date as `DateTimeImmutable` object.   | `DateTimeImmutable\|null` |

## Development

```bash
git clone git@github.com:ixnode/php-date-parser.git && cd php-date-parser
```

```bash
composer install
```

```bash
composer test
```

## License

This tool is licensed under the MIT License - see the [LICENSE](/LICENSE) file for details