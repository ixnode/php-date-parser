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
use Ixnode\PhpDateParser\Constants\Timezones;
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
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
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

    final public const FORMAT_DATE_REGEXP = '~^([0-9]{4})-([0-9]{2})-([0-9]{2})$~';

    final public const FORMAT_DATE_HOUR = 'Y-m-d H';

    final public const FORMAT_DATE_HOUR_REGEXP = '~^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2})$~';

    final public const FORMAT_DATE_HOUR_MINUTE = 'Y-m-d H:i';

    final public const FORMAT_DATE_HOUR_MINUTE_REGEXP = '~^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2})$~';

    final public const FORMAT_DATE_HOUR_MINUTE_SECOND = 'Y-m-d H:i:s';

    final public const FORMAT_DATE_HOUR_MINUTE_SECOND_REGEXP = '~^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})$~';

    final public const FORMAT_THIS_MONTH_FIRST = 'Y-m-1';

    final public const FORMAT_THIS_MONTH_LAST = 'Y-m-t';

    final public const FORMAT_THIS_YEAR_FIRST = 'Y-1-1';

    final public const FORMAT_THIS_YEAR_LAST = 'Y-12-31';

    final public const VALUE_NOW = 'now';

    final public const VALUE_NEXT_SECOND = 'next-second';

    final public const VALUE_THIS_SECOND = 'this-second';

    final public const VALUE_LAST_SECOND = 'last-second';

    final public const VALUE_NEXT_MINUTE = 'next-minute';

    final public const VALUE_THIS_MINUTE = 'this-minute';

    final public const VALUE_LAST_MINUTE = 'last-minute';

    final public const VALUE_NEXT_HOUR = 'next-hour';

    final public const VALUE_THIS_HOUR = 'this-hour';

    final public const VALUE_LAST_HOUR = 'last-hour';

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

    final public const SECONDS_AN_HOUR = 3600;

    final public const SECONDS_A_MINUTE = 60;

    final public const SECONDS_A_SECOND = 1;

    protected int $hourFirst = self::HOUR_FIRST;

    protected int $minuteFirst = self::MINUTE_FIRST;

    protected int $secondFirst = self::SECOND_FIRST;

    protected int $hourLast = self::HOUR_LAST;

    protected int $minuteLast = self::MINUTE_LAST;

    protected int $secondLast = self::SECOND_LAST;

    protected string|null $range;

    protected DateRange $dateRange;

    /**
     * @param string|null $range
     * @param DateTimeZone $dateTimeZoneInput
     * @throws ParserException
     * @throws TypeInvalidException
     * @throws CaseUnsupportedException
     */
    public function __construct(string|null $range, protected DateTimeZone $dateTimeZoneInput = new DateTimeZone('UTC'))
    {
        $this->range = !is_null($range) ? trim(strtolower($range)) : null;

        $dateRange = $this->parseRange($range);

        $this->dateRange = $this->getDateRangeInstance(
            $dateRange->getFrom(),
            $dateRange->getTo(),
            $dateTimeZoneInput
        );
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

        $this->setTimes();

        $matches = [];
        switch (true) {

            /* ==================
             * Second word parser
             * ==================
             */
            case $range === self::VALUE_NEXT_SECOND:
            case $range === self::VALUE_THIS_SECOND:
            case $range === self::VALUE_LAST_SECOND:
                /* Parses "next-second", "this-second", "last-second" date time. */
                $dateTimeFrom = $this->getDateTimeRaw(self::VALUE_TODAY, $this->getThisHour(), $this->getThisMinute(), $this->getThisSecond());
                $dateTimeTo = $this->getDateTimeRaw(self::VALUE_TODAY, $this->getThisHour(), $this->getThisMinute(), $this->getThisSecond());
                $direction = $this->getDirection($range, self::VALUE_NEXT_SECOND, self::VALUE_LAST_SECOND);
                $this->modifyDateTime($dateTimeFrom, self::SECONDS_A_SECOND, $direction);
                $this->modifyDateTime($dateTimeTo, self::SECONDS_A_SECOND, $direction);
                return $this->getDateRangeInstance($dateTimeFrom, $dateTimeTo);



            /* ==================
             * Minute word parser
             * ==================
             */
            case $range === self::VALUE_NEXT_MINUTE:
            case $range === self::VALUE_THIS_MINUTE:
            case $range === self::VALUE_LAST_MINUTE:
                /* Parses "next-minute", "this-minute", "last-minute" date time. */
                $dateTimeFrom = $this->getDateTimeRaw(self::VALUE_TODAY, $this->getThisHour(), $this->getThisMinute(), $this->secondFirst);
                $dateTimeTo = $this->getDateTimeRaw(self::VALUE_TODAY, $this->getThisHour(), $this->getThisMinute(), $this->secondLast);
                $direction = $this->getDirection($range, self::VALUE_NEXT_MINUTE, self::VALUE_LAST_MINUTE);
                $this->modifyDateTime($dateTimeFrom, self::SECONDS_A_MINUTE, $direction);
                $this->modifyDateTime($dateTimeTo, self::SECONDS_A_MINUTE, $direction);
                return $this->getDateRangeInstance($dateTimeFrom, $dateTimeTo);



            /* ================
             * Hour word parser
             * ================
             */
            case $range === self::VALUE_NEXT_HOUR:
            case $range === self::VALUE_THIS_HOUR:
            case $range === self::VALUE_LAST_HOUR:
                /* Parses "next-hour", "this-hour", "last-hour" date time. */
                $dateTimeFrom = $this->getDateTimeRaw(self::VALUE_TODAY, $this->getThisHour(), $this->minuteFirst, $this->secondFirst);
                $dateTimeTo = $this->getDateTimeRaw(self::VALUE_TODAY, $this->getThisHour(), $this->minuteLast, $this->secondLast);
                $direction = $this->getDirection($range, self::VALUE_NEXT_HOUR, self::VALUE_LAST_HOUR);
                $this->modifyDateTime($dateTimeFrom, self::SECONDS_AN_HOUR, $direction);
                $this->modifyDateTime($dateTimeTo, self::SECONDS_AN_HOUR, $direction);
                return $this->getDateRangeInstance($dateTimeFrom, $dateTimeTo);



            /* ===============
             * Day word parser
             * ===============
             */
            case $range === self::VALUE_TOMORROW:
                /* Parses "tomorrow" date. */
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(self::VALUE_TOMORROW, $this->hourFirst, $this->minuteFirst, $this->secondFirst),
                    $this->getDateTimeRaw(self::VALUE_TOMORROW, $this->hourLast, $this->minuteLast, $this->secondLast)
                );
            case $range === self::VALUE_TODAY:
                /* Parses "today" date. */
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(self::VALUE_NOW, $this->hourFirst, $this->minuteFirst, $this->secondFirst),
                    $this->getDateTimeRaw(self::VALUE_NOW, $this->hourLast, $this->minuteLast, $this->secondLast)
                );
            case $range === self::VALUE_YESTERDAY:
                /* Parses "yesterday" date. */
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(self::VALUE_YESTERDAY, $this->hourFirst, $this->minuteFirst, $this->secondFirst),
                    $this->getDateTimeRaw(self::VALUE_YESTERDAY, $this->hourLast, $this->minuteLast, $this->secondLast)
                );



            /* =================
             * Month word parser
             * =================
             */
            case $range === self::VALUE_NEXT_MONTH:
                /* Parses "next-month" date. */
                return $this->getDateRangeNextMonth();
            case $range === self::VALUE_THIS_MONTH:
                /* Parses "this-month" date. */
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(date(self::FORMAT_THIS_MONTH_FIRST), $this->hourFirst, $this->minuteFirst, $this->secondFirst),
                    $this->getDateTimeRaw(date(self::FORMAT_THIS_MONTH_LAST), $this->hourLast, $this->minuteLast, $this->secondLast)
                );
            case $range === self::VALUE_LAST_MONTH:
                /* Parses "last-month" date. */
                return $this->getDateRangeLastMonth();



            /* ================
             * Year word parser
             * ================
             */
            case $range === self::VALUE_NEXT_YEAR:
                /* Parses "next-year" date. */
                return $this->getDateRangeNextYear();
            case $range === self::VALUE_THIS_YEAR:
                /* Parses "this-year" date. */
                return $this->getDateRangeInstance(
                    $this->getDateTimeRaw(date(self::FORMAT_THIS_YEAR_FIRST), $this->hourFirst, $this->minuteFirst, $this->secondFirst),
                    $this->getDateTimeRaw(date(self::FORMAT_THIS_YEAR_LAST), $this->hourLast, $this->minuteLast, $this->secondLast)
                );
            case $range === self::VALUE_LAST_YEAR:
                /* Parses "last-year" date. */
                return $this->getDateRangeLastYear();



            /* =======================
             * Earlier than parser (<)
             * =======================
             */
            case preg_match('~^(<[+=]|-)~', $range, $matches) === 1:
                /* Starts with <+: parses a "∞ (infinity)" to given "from" date (including given date). */
                return $this->getDateRangeInstance(
                    null,
                    $this->parseRange(substr($range, strlen($matches[1])))->getTo()
                );
            case str_starts_with($range, '<'):
                /* Starts with <: parses a "∞ (infinity)" to given "from" date (excluding given date). */
                return $this->getDateRangeInstance(
                    null,
                    $this->parseRange(substr($range, 1))->getFrom()?->modify('-1 second')
                );



            /* =======================
             * Earlier than parser (<)
             * =======================
             */
            case preg_match('~^(>[+=]|[+])~', $range, $matches) === 1:
                /* Starts with >+: parses a given "from" (including given date) to "∞ (infinity)" date. */
                return $this->getDateRangeInstance(
                    $this->parseRange(substr($range, strlen($matches[1])))->getFrom(),
                    null
                );
            case str_starts_with($range, '>'):
                /* Starts with >: parses a given "from" (excluding given date) to "∞ (infinity)" date. */
                return $this->getDateRangeInstance(
                    $this->parseRange(substr($range, 1))->getTo()?->modify('+1 second'),
                    null
                );



            /* ================
             * Range parser (|)
             * ================
             */
            case str_contains($range, '|'):
                /* Starts with |: parses a given "from" (including given date) to "to" date (including given date). */
                $splitted = explode('|', $range);
                return $this->getDateRangeInstance(
                    $this->parseRange($splitted[0])->getFrom(),
                    $this->parseRange($splitted[1])->getTo()
                );



            /* ================
             * Equal parser (=)
             * ================
             */
            case str_starts_with($range, '='):
                /* Starts with =: a given date exactly. */
                return $this->getDateRangeInstance(
                    $this->parseRange(substr($range, 1))->getFrom(),
                    $this->parseRange(substr($range, 1))->getTo(),
                );



            /* ================
             * Date parser (Y-m-d [H[:i[:s]]])
             * ================
             */
            default:
                /* Parse the date */
                $dateTime = $this->parseDateTime($range);
                return $this->getDateRangeInstance(
                    (clone $dateTime)->setTime($this->hourFirst, $this->minuteFirst, $this->secondFirst),
                    (clone $dateTime)->setTime($this->hourLast, $this->minuteLast, $this->secondLast),
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
            ->setTime($this->hourLast, $this->minuteLast, $this->secondLast)
            ->modify('+1 second');

        $lastNextMonth = (new DateTime($firstNextMonth->format(self::FORMAT_THIS_MONTH_LAST)))
            ->setTime($this->hourLast, $this->minuteLast, $this->secondLast);

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
            ->setTime($this->hourFirst, $this->minuteFirst, $this->secondFirst)
            ->modify('-1 second')
            ->setTime($this->hourLast, $this->minuteLast, $this->secondLast);

        $firstLastMonth = (new DateTime($lastLastMonth->format(self::FORMAT_THIS_MONTH_FIRST)))
            ->setTime($this->hourFirst, $this->minuteFirst, $this->secondFirst);

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
            ->setTime($this->hourLast, $this->minuteLast, $this->secondLast)
            ->modify('+1 second');

        $lastNextYear = (new DateTime($firstNextYear->format(self::FORMAT_THIS_YEAR_LAST)))
            ->setTime($this->hourLast, $this->minuteLast, $this->secondLast);

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
            ->setTime($this->hourFirst, $this->minuteFirst, $this->secondFirst)
            ->modify('-1 second')
            ->setTime($this->hourLast, $this->minuteLast, $this->secondLast);

        $firstLastYear = (new DateTime($lastLastYear->format(self::FORMAT_THIS_YEAR_FIRST)))
            ->setTime($this->hourFirst, $this->minuteFirst, $this->secondFirst);

        return $this->getDateRangeInstance($firstLastYear, $lastLastYear);
    }

    /**
     * Sets first and last times.
     *
     * @param int|null $hourFirst
     * @param int|null $minuteFirst
     * @param int|null $secondFirst
     * @param int|null $hourLast
     * @param int|null $minuteLast
     * @param int|null $secondLast
     * @return void
     */
    private function setTimes(
        int|null $hourFirst = null,
        int|null $minuteFirst = null,
        int|null $secondFirst = null,
        int|null $hourLast = null,
        int|null $minuteLast = null,
        int|null $secondLast = null
    ): void
    {
        $this->hourFirst = $hourFirst ?: self::HOUR_FIRST;
        $this->minuteFirst = $minuteFirst ?: self::MINUTE_FIRST;
        $this->secondFirst = $secondFirst ?: self::SECOND_FIRST;
        $this->hourLast = $hourLast ?: self::HOUR_LAST;
        $this->minuteLast = $minuteLast ?: self::MINUTE_LAST;
        $this->secondLast = $secondLast ?: self::SECOND_LAST;
    }

    /**
     * Parses the given date time.
     *
     * @param string $dateTime
     * @return DateTime
     * @throws TypeInvalidException
     * @throws ParserException
     */
    protected function parseDateTime(string $dateTime): DateTime
    {
        $matches = [];
        switch (true) {
            case preg_match(self::FORMAT_DATE_HOUR_MINUTE_SECOND_REGEXP, $dateTime, $matches) > 0:
                $dateTime = date_create_from_format(self::FORMAT_DATE_HOUR_MINUTE_SECOND, $dateTime);
                $this->setTimes(
                    (int) $matches[4],
                    (int) $matches[5],
                    (int) $matches[6],
                    (int) $matches[4],
                    (int) $matches[5],
                    (int) $matches[6]
                );
                break;

            case preg_match(self::FORMAT_DATE_HOUR_MINUTE_REGEXP, $dateTime, $matches) > 0:
                $dateTime = date_create_from_format(self::FORMAT_DATE_HOUR_MINUTE, $dateTime);
                $this->setTimes(
                    (int) $matches[4],
                    (int) $matches[5],
                    null,
                    (int) $matches[4],
                    (int) $matches[5]
                );
                break;

            case preg_match(self::FORMAT_DATE_HOUR_REGEXP, $dateTime, $matches) > 0:
                $dateTime = date_create_from_format(self::FORMAT_DATE_HOUR, $dateTime);
                $this->setTimes(
                    (int) $matches[4],
                    null,
                    null,
                    (int) $matches[4]
                );
                break;

            case preg_match(self::FORMAT_DATE_REGEXP, $dateTime, $matches) > 0:
                $dateTime = date_create_from_format(self::FORMAT_DATE, $dateTime);
                $this->setTimes();
                break;

            default:
                throw new ParserException($dateTime, sprintf(
                 'String must be in the format "%s", "%s", "%s" or "%s".',
                 self::FORMAT_DATE,
                 self::FORMAT_DATE_HOUR,
                 self::FORMAT_DATE_HOUR_MINUTE,
                 self::FORMAT_DATE_HOUR_MINUTE_SECOND
               ));
        }

        if (!$dateTime instanceof DateTime) {
            throw new TypeInvalidException('object', gettype($dateTime));
        }

        return $dateTime;
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
     * @param DateTimeZone $dateTimeZoneInput
     * @return DateRange
     * @throws CaseUnsupportedException
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    protected function getDateRangeInstance(
        DateTime|DateTimeImmutable|null $from,
        DateTime|DateTimeImmutable|null $to,
        DateTimeZone $dateTimeZoneInput = new DateTimeZone(Timezones::UTC)
    ): DateRange
    {
        return new DateRange($from, $to, $dateTimeZoneInput);
    }

    /**
     * Returns this hour.
     *
     * @return int
     */
    private function getThisHour(): int
    {
        return (int) date('H');
    }

    /**
     * Returns this minute.
     *
     * @return int
     */
    private function getThisMinute(): int
    {
        return (int) date('i');
    }

    /**
     * Returns this second.
     *
     * @return int
     */
    private function getThisSecond(): int
    {
        return (int) date('s');
    }

    /**
     * Modify given date time object by given seconds.
     *
     * @param DateTime $dateTime
     * @param bool|null $direction
     * @param int $seconds
     * @return void
     */
    private function modifyDateTime(DateTime $dateTime, int $seconds, bool|null $direction): void
    {
        if ($direction === null) {
            return;
        }

        $dateTime->modify(sprintf('%s%d seconds', $direction ? '+' : '-', $seconds));
    }

    /**
     * Returns the direction of given range (next, last, etc.)
     *
     * @param string $range
     * @param string $next
     * @param string $last
     * @return bool|null
     */
    private function getDirection(string $range, string $next, string $last): bool|null
    {
        return match ($range) {
            $next => true,
            $last => false,
            default => null,
        };
    }
}
