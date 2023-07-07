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
use Ixnode\PhpDateParser\Tests\Unit\DateRangeTest;

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

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(
        DateTime|DateTimeImmutable|null $from,
        DateTime|DateTimeImmutable|null $to
    )
    {
        $this->from = match (true) {
            is_null($from) => null,
            $from instanceof DateTime => $from,
            $from instanceof DateTimeImmutable => DateTime::createFromImmutable($from)
        };
        $this->to = match (true) {
            is_null($to) => null,
            $to instanceof DateTime => $to,
            $to instanceof DateTimeImmutable => DateTime::createFromImmutable($to)
        };
    }

    /**
     * Returns the mutable representation from "from" value.
     *
     * @return DateTime|null
     */
    public function getFrom(): ?DateTime
    {
        return $this->from;
    }

    /**
     * Returns the mutable representation from "to" value.
     *
     * @return DateTime|null
     */
    public function getTo(): ?DateTime
    {
        return $this->to;
    }

    /**
     * Returns the immutable representation from "from" value.
     *
     * @return DateTimeImmutable|null
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getFromImmutable(): ?DateTimeImmutable
    {
        if (is_null($this->from)) {
            return null;
        }

        return DateTimeImmutable::createFromMutable($this->from);
    }

    /**
     * Returns the immutable representation from "to" value.
     *
     * @return DateTimeImmutable|null
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getToImmutable(): ?DateTimeImmutable
    {
        if (is_null($this->to)) {
            return null;
        }

        return DateTimeImmutable::createFromMutable($this->to);
    }
}
