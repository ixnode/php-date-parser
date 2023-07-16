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

namespace Ixnode\PhpDateParser\Base;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use Ixnode\PhpDateParser\DateRange;
use Ixnode\PhpException\Case\CaseUnsupportedException;
use Ixnode\PhpException\Parser\ParserException;
use Ixnode\PhpException\Type\TypeInvalidException;

/**
 * Class BaseDateParser
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-07-08)
 * @since 0.1.0 (2023-07-08) First version.
 */
class BaseDateParser
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

    final public const VALUE_NOW = 'now';

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

    protected DateRange $dateRange;

    /**
     * @param string|null $range
     * @param DateTimeZone $dateTimeZoneInput
     * @throws ParserException
     * @throws TypeInvalidException
     */
    public function __construct(string|null $range, protected DateTimeZone $dateTimeZoneInput = new DateTimeZone('UTC'))
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
            return $this->getDateRangeInstance(
                null,
                null
            );
        }

        $matches = [];

        switch (true) {

            /* Parses "tomorrow" date. */
            case $range === self::VALUE_TOMORROW:
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(self::VALUE_TOMORROW, self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    $this->getDateTimeRaw(self::VALUE_TOMORROW, self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );
            /* Parses "today" date. */
            case $range === self::VALUE_TODAY:
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(self::VALUE_NOW, self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    $this->getDateTimeRaw(self::VALUE_NOW, self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );
            /* Parses "yesterday" date. */
            case $range === self::VALUE_YESTERDAY:
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(self::VALUE_YESTERDAY, self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    $this->getDateTimeRaw(self::VALUE_YESTERDAY, self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );
            /* Parses "next-month" date. */
            case $range === self::VALUE_NEXT_MONTH:
                return $this->getDateRangeNextMonth();
            /* Parses "this-month" date. */
            case $range === self::VALUE_THIS_MONTH:
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(date(self::FORMAT_THIS_MONTH_FIRST), self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    $this->getDateTimeRaw(date(self::FORMAT_THIS_MONTH_LAST), self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );
            /* Parses "last-month" date. */
            case $range === self::VALUE_LAST_MONTH:
                return $this->getDateRangeLastMonth();
            /* Parses "next-year" date. */
            case $range === self::VALUE_NEXT_YEAR:
                return $this->getDateRangeNextYear();
            /* Parses "this-year" date. */
            case $range === self::VALUE_THIS_YEAR:
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(date(self::FORMAT_THIS_YEAR_FIRST), self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    $this->getDateTimeRaw(date(self::FORMAT_THIS_YEAR_LAST), self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
                );
            /* Parses "last-year" date. */
            case $range === self::VALUE_LAST_YEAR:
                return $this->getDateRangeLastYear();


            /* Starts with <+: parses a "∞ (infinity)" to given "from" date (including given date). */
            case preg_match('~^(<[+=]|-)~', $range, $matches) === 1:
                return $this->getDateRangeInstance(
                    null,
                    $this->parseRange(substr($range, strlen($matches[1])))->getTo()
                );
            /* Starts with <: parses a "∞ (infinity)" to given "from" date (excluding given date). */
            case str_starts_with($range, '<'):
                return $this->getDateRangeInstance(
                    null,
                    $this->parseRange(substr($range, 1))
                        ->getTo()
                        ?->modify(sprintf('-%d seconds', self::SECONDS_A_DAY))
                );


            /* Starts with >+: parses a given "from" (including given date) to "∞ (infinity)" date. */
            case preg_match('~^(>[+=]|[+])~', $range, $matches) === 1:
                return $this->getDateRangeInstance(
                    $this->parseRange(substr($range, strlen($matches[1])))->getFrom(),
                    null
                );
            /* Starts with >: parses a given "from" (excluding given date) to "∞ (infinity)" date. */
            case str_starts_with($range, '>'):
                return $this->getDateRangeInstance(
                    $this->parseRange(substr($range, 1))->getTo()?->modify('+1 second'),
                    null
                );


            /* Starts with |: parses a given "from" (including given date) to "to" date (including given date). */
            case str_contains($range, '|'):
                $splitted = explode('|', $range);
                return $this->getDateRangeInstance(
                    $this->parseRange($splitted[0])->getFrom(),
                    $this->parseRange($splitted[1])->getTo()
                );


            /* Starts with =: a given date exactly. */
            case str_starts_with($range, '='):
                return $this->getDateRangeInstance(
                    $this->parseRange(substr($range, 1))->getFrom(),
                    $this->parseRange(substr($range, 1))->getTo(),
                );


            /* Parse the date */
            default:
                return $this->getDateRangeInstance(
                    $this->parseDate($range)->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST),
                    $this->parseDate($range)->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST),
                );
        }
    }

    /**
     * Returns the DateRange Object from next month.
     *
     * @return DateRange
     * @throws Exception
     */
    private function getDateRangeNextMonth(): DateRange
    {
        $firstNextMonth = (new DateTime(date(self::FORMAT_THIS_MONTH_LAST)))
            ->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
            ->modify('+1 second');

        $lastNextMonth = (new DateTime($firstNextMonth->format(self::FORMAT_THIS_MONTH_LAST)))
            ->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST);

        return $this->getDateRangeInstance($firstNextMonth, $lastNextMonth);
    }

    /**
     * Returns the DateRange Object from last month.
     *
     * @return DateRange
     * @throws Exception
     */
    private function getDateRangeLastMonth(): DateRange
    {
        $lastLastMonth = (new DateTime(date(self::FORMAT_THIS_MONTH_FIRST)))
            ->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST)
            ->modify('-1 second')
            ->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST);

        $firstLastMonth = (new DateTime($lastLastMonth->format(self::FORMAT_THIS_MONTH_FIRST)))
            ->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST);

        return $this->getDateRangeInstance($firstLastMonth, $lastLastMonth);
    }

    /**
     * Returns the DateRange Object from next year.
     *
     * @return DateRange
     * @throws Exception
     */
    private function getDateRangeNextYear(): DateRange
    {
        $firstNextYear = (new DateTime(date(self::FORMAT_THIS_YEAR_LAST)))
            ->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST)
            ->modify('+1 second');

        $lastNextYear = (new DateTime($firstNextYear->format(self::FORMAT_THIS_YEAR_LAST)))
            ->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST);

        return $this->getDateRangeInstance($firstNextYear, $lastNextYear);
    }

    /**
     * Returns the DateRange Object from last year.
     *
     * @return DateRange
     * @throws Exception
     */
    private function getDateRangeLastYear(): DateRange
    {
        $lastLastYear = (new DateTime(date(self::FORMAT_THIS_YEAR_FIRST)))
            ->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST)
            ->modify('-1 second')
            ->setTime(self::HOUR_LAST, self::MINUTE_LAST, self::SECOND_LAST);

        $firstLastYear = (new DateTime($lastLastYear->format(self::FORMAT_THIS_YEAR_FIRST)))
            ->setTime(self::HOUR_FIRST, self::MINUTE_FIRST, self::SECOND_FIRST);

        return $this->getDateRangeInstance($firstLastYear, $lastLastYear);
    }

    /**
     * Parses the given date.
     *
     * @param string $date
     * @return DateTime
     * @throws TypeInvalidException
     * @throws ParserException
     */
    protected function parseDate(string $date): DateTime
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
     * @param string $dateTime
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return DateTime
     * @throws Exception
     */
    protected function getDateTimeRaw(string $dateTime, int $hour, int $minute, int $second): DateTime
    {
        return (new DateTime($dateTime))->setTime($hour, $minute, $second);
    }

    /**
     * Returns the DateRange instance from given date range.
     *
     * @param DateTime|DateTimeImmutable|null $from
     * @param DateTime|DateTimeImmutable|null $to
     * @return DateRange
     * @throws CaseUnsupportedException
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    protected function getDateRangeInstance(DateTime|DateTimeImmutable|null $from, DateTime|DateTimeImmutable|null $to): DateRange
    {
        return new DateRange($from, $to, $this->dateTimeZoneInput);
    }
}