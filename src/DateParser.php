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
use Ixnode\PhpDateParser\Tests\Unit\DateParserTest;
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

    final public const VALUE_TODAY = 'today';

    final public const VALUE_YESTERDAY = 'yesterday';

    final public const SECONDS_A_DAY = 86400;

    private DateRange $dateRange;

    /**
     * @param string $range
     * @throws TypeInvalidException
     */
    public function __construct(protected string $range)
    {
        $this->dateRange = $this->parseRange($range);
    }

    /**
     * Parses the given date range.
     *
     * @param string $range
     * @return DateRange
     * @throws TypeInvalidException
     */
    private function parseRange(string $range): DateRange
    {
        $range = trim(strtolower($range));

        switch (true) {
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

            /* Starts with <+: parses a "∞ (infinity)" to given "from" date (including given date). */
            case preg_match('~^<\+~', $range) === 1:
                return new DateRange(
                    null,
                    $this->parseRange(substr($range, 2))->getTo()
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
            case preg_match('~^>\+~', $range) === 1:
                return new DateRange(
                    $this->parseRange(substr($range, 2))->getFrom(),
                    null
                );

            /* Starts with +: parses a given "from" (including given date) to "∞ (infinity)" date. */
            case preg_match('~^\+~', $range) === 1:
                return new DateRange(
                    $this->parseRange(substr($range, 1))->getFrom(),
                    null
                );

            /* Starts with >: parses a given "from" (excluding given date) to "∞ (infinity)" date. */
            case str_starts_with($range, '>'):
                return new DateRange(
                    $this->parseRange(substr($range, 1))->getTo()?->modify('+1 second'),
                    null
                );

            /* Starts with +: parses a given "from" (including given date) to "∞ (infinity)" date. */
            case str_contains($range, '|'):
                $splitted = explode('|', $range);
                return new DateRange(
                    $this->parseRange($splitted[0])->getFrom(),
                    $this->parseRange($splitted[1])->getTo()
                );

            /* Parses a given date (exactly). */
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
     */
    private function parseDate(string $date): DateTime
    {
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
