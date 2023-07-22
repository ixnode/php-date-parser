# PHP Date Parser

[![Release](https://img.shields.io/github/v/release/ixnode/php-date-parser)](https://github.com/ixnode/php-date-parser/releases)
[![PHP](https://img.shields.io/badge/PHP-^8.2-777bb3.svg?logo=php&logoColor=white&labelColor=555555&style=flat)](https://www.php.net/supported-versions.php)
[![PHPStan](https://img.shields.io/badge/PHPStan-Level%20Max-brightgreen.svg?style=flat)](https://phpstan.org/user-guide/rule-levels)
[![PHPCS](https://img.shields.io/badge/PHPCS-PSR12-brightgreen.svg?style=flat)](https://www.php-fig.org/psr/psr-12/)
[![LICENSE](https://img.shields.io/github/license/ixnode/php-api-version-bundle)](https://github.com/ixnode/php-api-version-bundle/blob/master/LICENSE)

> This library parses various given date and time strings into
> DateTime or DateTimeImmutable classes which return the time
> range. Can be used e.g. excellently for command line
> arguments and options to make database queries with.

## Examples / Usage

```php
use Ixnode\PhpDateParser\DateParser;
```

### Date parser (`UTC`)

```php
print (new DateParser('2023-07-01'))->formatFrom('Y-m-d H:i:s');
// 2023-07-01 00:00:00

print (new DateParser('2023-07-01'))->formatTo('Y-m-d H:i:s');
// 2023-07-01 23:59:59
```

### Word parser (`UTC`)

*  Imagine that now is the time: `2023-07-07 12:34:56`

```php
print (new DateParser('today'))->formatFrom('Y-m-d H:i:s');
// 2023-07-07 00:00:00

print (new DateParser('today'))->formatTo('Y-m-d H:i:s');
// 2023-07-07 23:59:59
```

### Date parser with timezones

* Input: `America/New_York`
* Output: `Europe/Berlin`

```php
/* Parses given date time from timezone America/New_York; Output to timezone Europe/Berlin */
print (new DateParser('<2023-07-01', 'America/New_York'))->formatFrom('Y-m-d H:i:s', 'Europe/Berlin');
// null

/* Parses given date time from timezone America/New_York; Output to timezone Europe/Berlin */
print (new DateParser('<2023-07-01', 'America/New_York'))->formatTo('Y-m-d H:i:s', 'Europe/Berlin');
// 2023-07-01 05:59:59
```

### Working with `DateRange` class

```php
/* Parses given date time from timezone America/New_York */
$dateParser = (new DateParser('2023-07-01', 'America/New_York'));

/* Sets default output to timezone Asia/Tokyo */
$dateRange = $dateParser->getDateRange('Asia/Tokyo');

print $dateRange->getFrom()?->format('Y-m-d H:i:s (e)');
// 2023-07-01 13:00:00 (Asia/Tokyo)

print $dateRange->getTo()?->format('Y-m-d H:i:s (e)');
// 2023-07-02 12:59:59 (Asia/Tokyo)
```

## Parsing formats

### Supported words

| Word          | Description                   |
|---------------|-------------------------------|
| `next-second` | Next second (`'s' + 1`)       |
| `this-second` | This second (`'s'`)           |
| `last-second` | Last second (`'s' - 1`)       |
| `next-minute` | Next minute (`'i' + 1`)       |
| `this-minute` | This minute (`'i'`)           |
| `last-minute` | Last minute (`'i' - 1`)       |
| `next-hour`   | Next hour (`'G' + 1`)         |
| `this-hour`   | This hour (`'G'`)             |
| `last-hour`   | Last hour (`'G' - 1`)         |
| `tomorrow`    | The day tomorrow (`'j' + 1`)  |
| `today`       | The day today (`'j'`)         |
| `yesterday`   | The day yesterday (`'j' - 1`) |
| `next-month`  | Next month (`'n' + 1`)        |
| `this-month`  | This month (`'n'`)            |
| `last-month`  | Last month (`'n' - 1`)        |
| `next-year`   | Next year (`'Y' + 1`)         |
| `this-year`   | This year (`'Y'`)             |
| `last-year`   | Last year (`'Y' - 1`)         |

### Overview

#### Exact time parser (`=datetime`)

* Imagine that now is the time: `2023-07-07 12:34:56`

| Given format                            | Description                                             | From `('Y-m-d H:i:s')`               | To `('Y-m-d H:i:s')`                 |
|-----------------------------------------|---------------------------------------------------------|--------------------------------------|--------------------------------------|
| <nobr>`"tomorrow"`</nobr>               | Returns the date range from tomorrow.                   | <nobr>`"2023-07-08 00:00:00"`</nobr> | <nobr>`"2023-07-08 23:59:59"`</nobr> |
| <nobr>`"=tomorrow"`</nobr>              | Alias of `"tomorrow"`.                                  | <nobr>`"2023-07-08 00:00:00"`</nobr> | <nobr>`"2023-07-08 23:59:59"`</nobr> |
| <nobr>`"today"`</nobr>                  | Returns the date range from today.                      | <nobr>`"2023-07-07 00:00:00"`</nobr> | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"=today"`</nobr>                 | Alias of `"today"`.                                     | <nobr>`"2023-07-07 00:00:00"`</nobr> | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"yesterday"`</nobr>              | Returns the date range from yesterday.                  | <nobr>`"2023-07-06 00:00:00"`</nobr> | <nobr>`"2023-07-06 23:59:59"`</nobr> |
| <nobr>`"=yesterday"`</nobr>             | Alias of `"yesterday"`                                  | <nobr>`"2023-07-06 00:00:00"`</nobr> | <nobr>`"2023-07-06 23:59:59"`</nobr> |
| <nobr>`"this-month"`</nobr>             | Date range from first day to last day this month.       | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-31 23:59:59"`</nobr> |
| <nobr>`"=this-month"`</nobr>            | Alias of `"this-month"`                                 | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-31 23:59:59"`</nobr> |
| <nobr>`"2023-07-01"`</nobr>             | Exactly the given date.                                 | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-01 23:59:59"`</nobr> |
| <nobr>`"=2023-07-01"`</nobr>            | Alias of `"2023-07-01"`                                 | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-01 23:59:59"`</nobr> |

#### Time is greater than parser (`>from`)

* Imagine that now is the time: `2023-07-07 12:34:56`
* "To" values are `NULL`

| Given format                            | Description                                             | From `('Y-m-d H:i:s')`               | To `('Y-m-d H:i:s')`                 |
|-----------------------------------------|---------------------------------------------------------|--------------------------------------|--------------------------------------|
| <nobr>`">tomorrow"`</nobr>              | Later than tomorrow<sup>1)</sup>                        | <nobr>`"2023-07-09 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">=tomorrow"`</nobr>             | Later than tomorrow<sup>2)</sup>                        | <nobr>`"2023-07-08 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">+tomorrow"`</nobr>             | Alias of `">=tomorrow"`                                 | <nobr>`"2023-07-08 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`"+tomorrow"`</nobr>              | Alias of `">=tomorrow"`                                 | <nobr>`"2023-07-08 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">today"`</nobr>                 | Later than today<sup>1)</sup>                           | <nobr>`"2023-07-08 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">=today"`</nobr>                | Later than today<sup>2)</sup>                           | <nobr>`"2023-07-07 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">+today"`</nobr>                | Alias of `">=today"`                                    | <nobr>`"2023-07-07 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`"+today"`</nobr>                 | Alias of `">=today"`                                    | <nobr>`"2023-07-07 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">yesterday"`</nobr>             | Later than yesterday<sup>1)</sup>                       | <nobr>`"2023-07-07 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">=yesterday"`</nobr>            | Later than yesterday<sup>2)</sup>                       | <nobr>`"2023-07-06 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">+yesterday"`</nobr>            | Alias of `">=yesterday"`                                | <nobr>`"2023-07-06 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`"+yesterday"`</nobr>             | Alias of `">=yesterday"`                                | <nobr>`"2023-07-06 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">2023-07-01"`</nobr>            | Later than the given date<sup>1)</sup>                  | <nobr>`"2023-07-02 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">=2023-07-01"`</nobr>           | Later than the given date<sup>2)</sup>                  | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`">+2023-07-01"`</nobr>           | Alias of `">=2023-07-01"`                               | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |
| <nobr>`"+2023-07-01"`</nobr>            | Alias of `">=2023-07-01"`                               | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`NULL`</nobr>                  |

* <sup>1)</sup> - excluding the given one
* <sup>2)</sup> - including the given one
* 
#### Time is less than parser (`<to`)

* Imagine that now is the time: `2023-07-07 12:34:56`
* "From" values are `NULL`

| Given format                            | Description                                             | From `('Y-m-d H:i:s')`               | To `('Y-m-d H:i:s')`                 |
|-----------------------------------------|---------------------------------------------------------|--------------------------------------|--------------------------------------|
| <nobr>`"<tomorrow"`</nobr>              | Before tomorrow<sup>1)</sup>                            | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"<=tomorrow"`</nobr>             | Before tomorrow<sup>2)</sup>                            | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-08 23:59:59"`</nobr> |
| <nobr>`"<+tomorrow"`</nobr>             | Alias of `"<=tomorrow"`                                 | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-08 23:59:59"`</nobr> |
| <nobr>`"-tomorrow"`</nobr>              | Alias of `"<=tomorrow"`                                 | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-08 23:59:59"`</nobr> |
| <nobr>`"<today"`</nobr>                 | Before today<sup>1)</sup>                               | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-06 23:59:59"`</nobr> |
| <nobr>`"<=today"`</nobr>                | Before today<sup>2)</sup>                               | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"<+today"`</nobr>                | Alias of `"<=today"`                                    | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"-today"`</nobr>                 | Alias of `"<=today"`                                    | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"<yesterday"`</nobr>             | Before yesterday<sup>1)</sup>                           | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-05 23:59:59"`</nobr> |
| <nobr>`"<=yesterday"`</nobr>            | Before yesterday<sup>2)</sup>                           | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-06 23:59:59"`</nobr> |
| <nobr>`"<+yesterday"`</nobr>            | Alias of `"<=yesterday"`                                | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-06 23:59:59"`</nobr> |
| <nobr>`"-yesterday"`</nobr>             | Alias of `"<=yesterday"`                                | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-06 23:59:59"`</nobr> |
| <nobr>`"<2023-07-01"`</nobr>            | Before the given date<sup>1)</sup>                      | <nobr>`NULL`</nobr>                  | <nobr>`"2023-06-30 23:59:59"`</nobr> |
| <nobr>`"<=2023-07-01"`</nobr>           | Before the given date<sup>2)</sup>                      | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-01 23:59:59"`</nobr> |
| <nobr>`"<+2023-07-01"`</nobr>           | Alias of `"<=2023-07-01"`                               | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-01 23:59:59"`</nobr> |
| <nobr>`"-2023-07-01"`</nobr>            | Alias of `"<=2023-07-01"`                               | <nobr>`NULL`</nobr>                  | <nobr>`"2023-07-01 23:59:59"`</nobr> |

* <sup>1)</sup> - excluding the given one
* <sup>2)</sup> - including the given one

#### Range parser (`from|to`)

* Imagine that now is the time: `2023-07-07 12:34:56`

| Given format                            | Description                                             | From `('Y-m-d H:i:s')`               | To `('Y-m-d H:i:s')`                 |
|-----------------------------------------|---------------------------------------------------------|--------------------------------------|--------------------------------------|
| <nobr>`"2023-07-01\|2023-07-03"`</nobr> | Date range from `"2023-07-01"` to `"2023-07-03"`        | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-03 23:59:59"`</nobr> |
| <nobr>`"2023-07-01\|tomorrow"`</nobr>   | Date range from `"2023-07-01"` to `"tomorrow"`          | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-08 23:59:59"`</nobr> |
| <nobr>`"2023-07-01\|today"`</nobr>      | Date range from `"2023-07-01"` to `"today"`             | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"2023-07-01\|yesterday"`</nobr>  | Date range from `"2023-07-01"` to `"yesterday"`         | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-06 23:59:59"`</nobr> |
| <nobr>`"yesterday\|today"`</nobr>       | Date range from `"yesterday"` to `"today"`              | <nobr>`"2023-07-06 00:00:00"`</nobr> | <nobr>`"2023-07-07 23:59:59"`</nobr> |
| <nobr>`"yesterday\|this-month"`</nobr>  | Date range from `"yesterday"` to last day of this month | <nobr>`"2023-07-06 00:00:00"`</nobr> | <nobr>`"2023-07-31 23:59:59"`</nobr> |
| <nobr>`"this-month\|today"`</nobr>      | Date range from first day this month to `"today"`       | <nobr>`"2023-07-01 00:00:00"`</nobr> | <nobr>`"2023-07-07 23:59:59"`</nobr> |

#### Infinitive range parser (`NULL`)

| Given format                            | Description                                             | From `('Y-m-d H:i:s')`               | To `('Y-m-d H:i:s')`                 |
|-----------------------------------------|---------------------------------------------------------|--------------------------------------|--------------------------------------|
| <nobr>`NULL`</nobr>                     | No range given (infinitive range).                      | <nobr>`NULL`</nobr>                  | <nobr>`NULL`</nobr>                  |

## Methods

### Class `DateParser`

| method                                                                        | description                                            | type                      |
|-------------------------------------------------------------------------------|--------------------------------------------------------|---------------------------|
| <nobr>`->formatFrom(string $format, DateTimeZone $dateTimeZoneOutput)`</nobr> | Returns the formatted "from" date.                     | `string`                  |
| <nobr>`->formatTo(string $format, DateTimeZone $dateTimeZoneOutput)`</nobr>   | Returns the formatted "to" date.                       | `string`                  |
| <nobr>`->getDateRange()`</nobr>                                               | Returns the range as `DateRange` class.                | `DateRange`               |
| <nobr>`->getFrom(DateTimeZone $dateTimeZoneOutput)`</nobr>                    | Returns the "from" date as `DateTime` object.          | `DateTime\|null`          |
| <nobr>`->getTo(DateTimeZone $dateTimeZoneOutput)`</nobr>                      | Returns the "to" date as `DateTime` object.            | `DateTime\|null`          |
| <nobr>`->getFromImmutable(DateTimeZone $dateTimeZoneOutput)`</nobr>           | Returns the "from" date as `DateTimeImmutable` object. | `DateTimeImmutable\|null` |
| <nobr>`->getToImmutable(DateTimeZone $dateTimeZoneOutput)`</nobr>             | Returns the "to" date as `DateTimeImmutable` object.   | `DateTimeImmutable\|null` |

## Installation

```bash
composer require ixnode/php-date-parser
```

```bash
vendor/bin/php-date-parser --version
```

```bash
0.1.10 (2023-07-21 21:39:44) - Björn Hempel <bjoern@hempel.li>
```

## Command line tool

Used to quickly check a given date time directly in the command line.

```bash
vendor/bin/php-date-parser pdt --timezone-input=America/New_York --timezone-output=Europe/Berlin "<2023-07-01"
```

```text

Given date time range: "<2023-07-01" (America/New_York > Europe/Berlin)

+----------------------------------------------------------+------------------+
| Value                                                    | Given            |
+----------------------------------------------------------+------------------+
| Given date time range (America/New_York > Europe/Berlin) | <2023-07-01      |
| Timezone (input)                                         | America/New_York |
| Timezone (output)                                        | Europe/Berlin    |
+----------------------------------------------------------+------------------+

Parsed from given string (input):

+------+-------------+---------------------+---------------------+
| Type | Format      | UTC                 | America/New York    |
+------+-------------+---------------------+---------------------+
| From | Y-m-d H:i:s | n/a                 | n/a                 |
| To   | Y-m-d H:i:s | 2023-07-01 03:59:59 | 2023-06-30 23:59:59 |
+------+-------------+---------------------+---------------------+

Parsed output:

+------+-------------+---------------------+---------------------+
| Type | Format      | UTC                 | Europe/Berlin       |
+------+-------------+---------------------+---------------------+
| From | Y-m-d H:i:s | n/a                 | n/a                 |
| To   | Y-m-d H:i:s | 2023-07-01 03:59:59 | 2023-07-01 05:59:59 |
+------+-------------+---------------------+---------------------+

```

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