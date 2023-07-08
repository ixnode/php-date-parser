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
use Ixnode\PhpDateParser\Base\BaseDateParser;
use Ixnode\PhpDateParser\Tests\Unit\DateParserTest;

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
