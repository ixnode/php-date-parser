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
use DateTimeZone;
use Ixnode\PhpDateParser\Base\BaseDateParser;
use Ixnode\PhpDateParser\Constants\Timezones;
use Ixnode\PhpDateParser\Tests\Unit\DateParserTest;
use Ixnode\PhpException\Case\CaseUnsupportedException;

/**
 * Class DateParser
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-07-07)
 * @since 0.1.0 (2023-07-07) First version.
 * @link DateParserTest
 */
class DateParser extends BaseDateParser
{
    /**
     * Returns the date range.
     *
     * @param DateTimeZone|string|null $dateTimeZone
     * @return DateRange
     */
    public function getDateRange(DateTimeZone|string $dateTimeZone = null): DateRange
    {
        if (!is_null($dateTimeZone)) {
            $this->setDefaultDateTimeZone($dateTimeZone);
        }

        return $this->dateRange;
    }

    /**
     * Returns the "from" date as string.
     *
     * @param string $format
     * @param DateTimeZone|null $dateTimeZone
     * @return string|null
     * @throws CaseUnsupportedException
     */
    public function formatFrom(string $format, DateTimeZone $dateTimeZone = null): string|null
    {
        return $this->dateRange->getFrom($dateTimeZone)?->format($format);
    }

    /**
     * Returns the "to" date as string.
     *
     * @param string $format
     * @param DateTimeZone $dateTimeZone
     * @return string|null
     * @throws CaseUnsupportedException
     */
    public function formatTo(string $format, DateTimeZone $dateTimeZone = new DateTimeZone(Timezones::UTC)): string|null
    {
        return $this->dateRange->getTo($dateTimeZone)?->format($format);
    }

    /**
     * Returns the "from" date as DateTime object.
     *
     * @param DateTimeZone $dateTimeZone
     * @return DateTime|null
     * @throws CaseUnsupportedException
     */
    public function getFrom(DateTimeZone $dateTimeZone = new DateTimeZone(Timezones::UTC)): DateTime|null
    {
        return $this->dateRange->getFrom($dateTimeZone);
    }

    /**
     * Returns the "to" date as DateTime object.
     *
     * @param DateTimeZone $dateTimeZone
     * @return DateTime|null
     * @throws CaseUnsupportedException
     */
    public function getTo(DateTimeZone $dateTimeZone = new DateTimeZone(Timezones::UTC)): DateTime|null
    {
        return $this->dateRange->getTo($dateTimeZone);
    }

    /**
     * Returns the "from" date as DateTimeImmutable object.
     *
     * @param DateTimeZone $dateTimeZone
     * @return DateTimeImmutable|null
     * @throws CaseUnsupportedException
     */
    public function getFromImmutable(DateTimeZone $dateTimeZone = new DateTimeZone(Timezones::UTC)): DateTimeImmutable|null
    {
        return $this->dateRange->getFromImmutable($dateTimeZone);
    }

    /**
     * Returns the "to" date as DateTimeImmutable object.
     *
     * @param DateTimeZone $dateTimeZone
     * @return DateTimeImmutable|null
     * @throws CaseUnsupportedException
     */
    public function getToImmutable(DateTimeZone $dateTimeZone = new DateTimeZone(Timezones::UTC)): DateTimeImmutable|null
    {
        return $this->dateRange->getToImmutable($dateTimeZone);
    }
}
