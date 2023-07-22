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
use Exception;
use Ixnode\PhpDateParser\Base\BaseDateParser;
use Ixnode\PhpDateParser\Constants\Timezones;
use Ixnode\PhpDateParser\Tests\Unit\DateRangeTest;
use Ixnode\PhpException\Case\CaseUnsupportedException;

/**
 * Class DateRange
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-07-07)
 * @since 0.1.0 (2023-07-07) First version.
 * @link DateRangeTest
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class DateRange
{
    private ?DateTime $from;

    private ?DateTime $to;

    protected DateTimeZone $defaultDateTimeZone;

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @throws CaseUnsupportedException
     */
    public function __construct(
        DateTime|DateTimeImmutable|null $from,
        DateTime|DateTimeImmutable|null $to,
        protected DateTimeZone $dateTimeZoneInput = new DateTimeZone(Timezones::UTC)
    )
    {
        $this->from = match (true) {
            is_null($from) => null,
            $from instanceof DateTime => $this->convertTimezone($from, $dateTimeZoneInput),
            $from instanceof DateTimeImmutable => $this->convertTimezone(DateTime::createFromImmutable($from), $dateTimeZoneInput)
        };
        $this->to = match (true) {
            is_null($to) => null,
            $to instanceof DateTime => $this->convertTimezone($to, $dateTimeZoneInput),
            $to instanceof DateTimeImmutable => $this->convertTimezone(DateTime::createFromImmutable($to), $dateTimeZoneInput)
        };

        $this->defaultDateTimeZone = new DateTimeZone(Timezones::UTC);
    }

    /**
     * Returns the default date time zone.
     *
     * @return DateTimeZone
     */
    public function getDefaultDateTimeZone(): DateTimeZone
    {
        return $this->defaultDateTimeZone;
    }

    /**
     * Sets the default date time zone.
     *
     * @param DateTimeZone|string $defaultDateTimeZone
     * @return self
     * @throws Exception
     */
    public function setDefaultDateTimeZone(DateTimeZone|string $defaultDateTimeZone): self
    {
        if (is_string($defaultDateTimeZone)) {
            $defaultDateTimeZone = new DateTimeZone($defaultDateTimeZone);
        }

        $this->defaultDateTimeZone = $defaultDateTimeZone;

        return $this;
    }

    /**
     * Returns the mutable representation from "from" value.
     *
     * @param DateTimeZone|null $dateTimeZone
     * @return DateTime|null
     * @throws CaseUnsupportedException
     */
    public function getFrom(DateTimeZone $dateTimeZone = null): ?DateTime
    {
        if (null === $this->from) {
            return null;
        }

        if (is_null($dateTimeZone)) {
            $dateTimeZone = $this->defaultDateTimeZone;
        }

        $from = clone $this->from;

        return $this->convertTimezone($from, new DateTimeZone(Timezones::UTC), $dateTimeZone);
    }

    /**
     * Returns the mutable representation from "to" value.
     *
     * @param DateTimeZone|null $dateTimeZone
     * @return DateTime|null
     * @throws CaseUnsupportedException
     */
    public function getTo(DateTimeZone $dateTimeZone = null): ?DateTime
    {
        if (null === $this->to) {
            return null;
        }

        if (is_null($dateTimeZone)) {
            $dateTimeZone = $this->defaultDateTimeZone;
        }

        $to = clone $this->to;

        return $this->convertTimezone($to, new DateTimeZone(Timezones::UTC), $dateTimeZone);
    }

    /**
     * Returns the immutable representation from "from" value.
     *
     * @param DateTimeZone|null $dateTimeZone
     * @return DateTimeImmutable|null
     * @throws CaseUnsupportedException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getFromImmutable(DateTimeZone $dateTimeZone = null): ?DateTimeImmutable
    {
        $from = $this->getFrom($dateTimeZone);

        if (is_null($from)) {
            return null;
        }

        return DateTimeImmutable::createFromMutable($from);
    }

    /**
     * Returns the immutable representation from "to" value.
     *
     * @param DateTimeZone|null $dateTimeZone
     * @return DateTimeImmutable|null
     * @throws CaseUnsupportedException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getToImmutable(DateTimeZone $dateTimeZone = null): ?DateTimeImmutable
    {
        $to = $this->getTo($dateTimeZone);

        if (is_null($to)) {
            return null;
        }

        return DateTimeImmutable::createFromMutable($to);
    }

    /**
     * Returns a DateTime instance with timezone UTC.
     *
     * @param DateTime $dateTime
     * @param DateTimeZone $dateTimeZoneInput
     * @param DateTimeZone $dateTimeZoneOutput
     * @return DateTime
     * @throws CaseUnsupportedException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function convertTimezone(
        DateTime $dateTime,
        DateTimeZone $dateTimeZoneInput = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneOutput = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        if ($dateTimeZoneOutput->getName() === $dateTimeZoneInput->getName()) {
            return $dateTime;
        }

        $dateTimeWithTimezone = DateTime::createFromFormat(
            BaseDateParser::FORMAT_DEFAULT,
            $dateTime->format(BaseDateParser::FORMAT_DEFAULT),
            $dateTimeZoneInput
        );

        if ($dateTimeWithTimezone === false) {
            throw new CaseUnsupportedException('Unable to create DateTime format.');
        }

        $dateTimeWithTimezone->setTimezone($dateTimeZoneOutput);

        return $dateTimeWithTimezone;
    }
}
