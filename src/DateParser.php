<?php

/*
 * This file is part of the ixnode/php-date-parser project.
 *
 * (c) Björn Hempel <https://www.hempel.li/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ixnode\PhpDateParser;

use DateTime;
use DateTimeImmutable;
use Exception;
use Ixnode\PhpDateParser\Tests\Unit\DateParserTest;
use Ixnode\PhpException\Parser\ParserException;
use Ixnode\PhpException\Type\TypeInvalidException;

/**
 * Class DateParser
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-07-07)
 * @since 0.1.0 (2023-07-07) First version.
 * @link DateParserTest
 */
class DateParser
{
    final public const HOUR_FIRST = 0;

    final public const MINUTE_FIRST = 0;

    final public const SECOND_FIRST = 0;

    final public const HOUR_LAST = 23;

    final public const MINUTE_LAST = 59;

    final public const SECOND_LAST = 59;

    final public const FORMAT_DEFAULT = 'Y-m-d H:i:s';

    final public const FORMAT_DATE = 'Y-m-d';

    final public const FORMAT_THIS_MONTH_FIRST = 'Y-m-1';

    final public const FORMAT_THIS_MONTH_LAST = 'Y-m-t';

    final public const FORMAT_THIS_YEAR_FIRST = 'Y-1-1';

    final public const FORMAT_THIS_YEAR_LAST = 'Y-12-31';

    final public const VALUE_TOMORROW = 'tomorrow';

    final public const VALUE_TODAY = 'today';

    final public const VALUE_YESTERDAY = 'yesterday';

    final public const VALUE_NEXT_MONTH = 'next-month';

    final public const VALUE_THIS_MONTH = 'this-month';

    final public const VALUE_LAST_MONTH = 'last-month';

    final public const VALUE_NEXT_YEAR = 'next-year';

    final public const VALUE_THIS_YEAR = 'this-year';

    final public const VALUE_LAST_YEAR = 'last-year';

    final public const SECONDS_A_DAY = 86400;

    protected string|null $range;

    private DateRange $dateRange;

    /**
     * @param string|null $range
     * @throws TypeInvalidException
     * @throws ParserException
     */
    public function __construct(string|null $range)
    {
        $this->range = !is_null($range) ? trim(strtolower($range)) : null;

        $this->dateRange = $this->parseRange($range);
    }

    /**
     * Parses the given date range.
     *
     * @param string|null $range
     * @return DateRange
     * @throws TypeInvalidException
     * @throws ParserException
     * @throws Exception
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    private function parseRange(string|null $range): DateRange
    {
        if (is_null($range)) {
            return new DateRange(
                null,
                null
            );
        }

        $matches = [];

        switch (true) {

            /* Parses "tomorrow" date. */
            case $range === self::VALUE_TOMORROW:
                return new DateRange(
                    (new DateTime(self::VALUE_TOMORROW))->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    (new DateTime(self::VALUE_TOMORROW))->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );
            /* Parses "today" date. */
            case $range === self::VALUE_TODAY:
                return new DateRange(
                    (new DateTime())->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    (new DateTime())->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );
            /* Parses "yesterday" date. */
            case $range === self::VALUE_YESTERDAY:
                return new DateRange(
                    (new DateTime(self::VALUE_YESTERDAY))->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    (new DateTime(self::VALUE_YESTERDAY))->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );
            /* Parses "next-month" date. */
            case $range === self::VALUE_NEXT_MONTH:
                $firstNextMonth = (new DateTime(date(self::FORMAT_THIS_MONTH_LAST)))
                    ->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                    ->modify('+1 second');
                $lastNextMonth = (new DateTime($firstNextMonth->format(self::FORMAT_THIS_MONTH_LAST)))
                    ->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST);
                return new DateRange($firstNextMonth, $lastNextMonth);
            /* Parses "this-month" date. */
            case $range === self::VALUE_THIS_MONTH:
                return new DateRange(
                    (new DateTime(date(self::FORMAT_THIS_MONTH_FIRST)))->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    (new DateTime(date(self::FORMAT_THIS_MONTH_LAST)))->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );
            /* Parses "last-month" date. */
            case $range === self::VALUE_LAST_MONTH:
                $lastLastMonth = (new DateTime(date(self::FORMAT_THIS_MONTH_FIRST)))
                    ->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST)
                    ->modify('-1 second')
                    ->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST);
                $firstLastMonth = (new DateTime($lastLastMonth->format(self::FORMAT_THIS_MONTH_FIRST)))
                    ->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST);
                return new DateRange($firstLastMonth, $lastLastMonth);
            /* Parses "this-year" date. */
            case $range === self::VALUE_THIS_YEAR:
                return new DateRange(
                    (new DateTime(date(self::FORMAT_THIS_YEAR_FIRST)))->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    (new DateTime(date(self::FORMAT_THIS_YEAR_LAST)))->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );


            /* Starts with <+: parses a "∞ (infinity)" to given "from" date (including given date). */
            case preg_match('~^(<[+=]|-)~', $range, $matches) === 1:
                return new DateRange(
                    null,
                    $this->parseRange(substr($range, strlen($matches[1])))->getTo()
                );
            /* Starts with <: parses a "∞ (infinity)" to given "from" date (excluding given date). */
            case str_starts_with($range, '<'):
                return new DateRange(
                    null,
                    $this->parseRange(substr($range, 1))
                        ->getTo()
                        ?->modify(sprintf('-%d seconds', self::SECONDS_A_DAY))
                );


            /* Starts with >+: parses a given "from" (including given date) to "∞ (infinity)" date. */
            case preg_match('~^(>[+=]|[+])~', $range, $matches) === 1:
                return new DateRange(
                    $this->parseRange(substr($range, strlen($matches[1])))->getFrom(),
                    null
                );
            /* Starts with >: parses a given "from" (excluding given date) to "∞ (infinity)" date. */
            case str_starts_with($range, '>'):
                return new DateRange(
                    $this->parseRange(substr($range, 1))->getTo()?->modify('+1 second'),
                    null
                );


            /* Starts with |: parses a given "from" (including given date) to "to" date (including given date). */
            case str_contains($range, '|'):
                $splitted = explode('|', $range);
                return new DateRange(
                    $this->parseRange($splitted[0])->getFrom(),
                    $this->parseRange($splitted[1])->getTo()
                );


            /* Starts with =: a given date exactly. */
            case str_starts_with($range, '='):
                return new DateRange(
                    $this->parseRange(substr($range, 1))->getFrom(),
                    $this->parseRange(substr($range, 1))->getTo(),
                );


            /* Parse the date */
            default:
                return new DateRange(
                    $this->parseDate($range)->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    $this->parseDate($range)->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST),
                );
        }
    }

    /**
     * Parses the given date.
     *
     * @param string $date
     * @return DateTime
     * @throws TypeInvalidException
     * @throws ParserException
     */
    private function parseDate(string $date): DateTime
    {
        if (!preg_match('~^[0-9]{4}-[0-9]{2}-[0-9]{2}$~', $date)) {
            throw new ParserException($date, sprintf('String must be in the format "%s".', self::FORMAT_DATE));
        }

        $date = date_create_from_format(self::FORMAT_DATE, $date);

        if (!$date instanceof DateTime) {
            throw new TypeInvalidException('object', gettype($date));
        }

        return $date;
    }

    /**
     * Returns the date range.
     *
     * @return DateRange
     */
    public function getDateRange(): DateRange
    {
        return $this->dateRange;
    }

    /**
     * Returns the "from" date as string.
     *
     * @param string $format
     * @return string|null
     */
    public function formatFrom(string $format): string|null
    {
        return $this->dateRange->getFrom()?->format($format);
    }

    /**
     * Returns the "to" date as string.
     *
     * @param string $format
     * @return string|null
     */
    public function formatTo(string $format): string|null
    {
        return $this->dateRange->getTo()?->format($format);
    }

    /**
     * Returns the "from" date as DateTime object.
     *
     * @return DateTime|null
     */
    public function getFrom(): DateTime|null
    {
        return $this->dateRange->getFrom();
    }

    /**
     * Returns the "to" date as DateTime object.
     *
     * @return DateTime|null
     */
    public function getTo(): DateTime|null
    {
        return $this->dateRange->getTo();
    }

    /**
     * Returns the "from" date as DateTimeImmutable object.
     *
     * @return DateTimeImmutable|null
     */
    public function getFromImmutable(): DateTimeImmutable|null
    {
        return $this->dateRange->getFromImmutable();
    }

    /**
     * Returns the "to" date as DateTimeImmutable object.
     *
     * @return DateTimeImmutable|null
     */
    public function getToImmutable(): DateTimeImmutable|null
    {
        return $this->dateRange->getToImmutable();
    }
}
