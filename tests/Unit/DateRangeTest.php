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

namespace Ixnode\PhpDateParser\Tests\Unit;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Ixnode\PhpDateParser\Constants\Timezones;
use Ixnode\PhpDateParser\DateRange;
use Ixnode\PhpException\Case\CaseUnsupportedException;
use PHPUnit\Framework\TestCase;

/**
 * Class DateRangeTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-07-07)
 * @since 0.1.0 (2023-07-07) First version.
 * @link DateRange
 */
final class DateRangeTest extends TestCase
{
    /**
     * Test wrapper.
     *
     * @dataProvider dataProviderTypeDateTime
     * @dataProvider dataProviderTypeDateTimeImmutable
     * @dataProvider dataProviderTypeDateTimeFormat
     * @dataProvider dataProviderTypeDateTimeImmutableFormat
     * @dataProvider dataProviderTypeDateTimeFormatEuropeBerlin
     * @dataProvider dataProviderTypeDateTimeImmutableFormatEuropeBerlin
     *
     * @test
     * @testdox $number) Test Range: $method
     * @param int $number
     * @param string $method
     * @param mixed $parameter
     * @param DateTime|DateTimeImmutable|null $from
     * @param DateTime|DateTimeImmutable|null $to
     * @param string|null $format
     * @param class-string|null $expected
     * @throws CaseUnsupportedException
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function wrapperType(
        int $number,
        string $method,
        mixed $parameter,
        DateTime|DateTimeImmutable|null $from,
        DateTime|DateTimeImmutable|null $to,
        string|null $format,
        string|null $expected
    ): void
    {
        /* Arrange */

        /* Act */
        $dateRange = new DateRange($from, $to);
        $callback = [$dateRange, $method];

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertContains($method, get_class_methods(DateRange::class));
        $this->assertIsCallable($callback);

        /** @var DateTime|DateTimeImmutable|null $result */
        $result = match (true) {
            is_null($parameter) => $dateRange->{$method}(),
            default => $dateRange->{$method}($parameter),
        };

        match (true) {
            is_null($format) => $this->assertSame($expected, is_null($result) ? null : $result::class),
            default => $this->assertSame($expected, is_null($result) ? null : $result->format($format)),
        };
    }

    /**
     * Data provider (getFrom and getTo).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderTypeDateTime(): array
    {
        $number = 0;

        return [

            /**
             * Simple tests (getFrom).
             */
            [
                ++$number, 'getFrom', null,
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                null,
                DateTime::class
            ],
            [
                ++$number, 'getFrom', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                null,
                DateTime::class
            ],
            [
                ++$number, 'getFrom', null,
                null,
                new DateTime('2023-07-07 23:59:59'),
                null,
                null
            ],

            /**
             * Simple tests (getTo).
             */
            [
                ++$number, 'getTo', null,
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                null,
                DateTime::class
            ],
            [
                ++$number, 'getTo', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                null,
                DateTime::class
            ],
            [
                ++$number, 'getTo', null,
                new DateTime('2023-07-07 00:00:00'),
                null,
                null,
                null
            ],
        ];
    }

    /**
     * Data provider (getFromImmutable and getToImmutable).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderTypeDateTimeImmutable(): array
    {
        $number = 0;

        return [

            /**
             * Simple tests (getFromImmutable).
             */
            [
                ++$number, 'getFromImmutable', null,
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                null,
                DateTimeImmutable::class
            ],
            [
                ++$number, 'getFromImmutable', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                null,
                DateTimeImmutable::class
            ],
            [
                ++$number, 'getFromImmutable', null,
                null,
                new DateTime('2023-07-07 23:59:59'),
                null,
                null
            ],

            /**
             * Simple tests (getToImmutable).
             */
            [
                ++$number, 'getToImmutable', null,
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                null,
                DateTimeImmutable::class
            ],
            [
                ++$number, 'getToImmutable', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                null,
                DateTimeImmutable::class
            ],
            [
                ++$number, 'getToImmutable', null,
                new DateTime('2023-07-07 00:00:00'),
                null,
                null,
                null
            ],
        ];
    }

    /**
     * Data provider (getFrom and getTo).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderTypeDateTimeFormat(): array
    {
        $number = 0;

        return [

            /**
             * Simple tests (getFrom).
             */
            [
                ++$number, 'getFrom', null,
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 00:00:00'
            ],
            [
                ++$number, 'getFrom', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 00:00:00'
            ],
            [
                ++$number, 'getFrom', null,
                null,
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                null
            ],

            /**
             * Simple tests (getTo).
             */
            [
                ++$number, 'getTo', null,
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 23:59:59'
            ],
            [
                ++$number, 'getTo', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 23:59:59'
            ],
            [
                ++$number, 'getTo', null,
                new DateTime('2023-07-07 00:00:00'),
                null,
                'Y-m-d H:i:s',
                null
            ],
        ];
    }

    /**
     * Data provider (getFromImmutable and getToImmutable).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderTypeDateTimeImmutableFormat(): array
    {
        $number = 0;

        return [

            /**
             * Simple tests (getFromImmutable).
             */
            [
                ++$number, 'getFromImmutable', null,
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 00:00:00'
            ],
            [
                ++$number, 'getFromImmutable', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 00:00:00'
            ],
            [
                ++$number, 'getFromImmutable', null,
                null,
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                null
            ],

            /**
             * Simple tests (getToImmutable).
             */
            [
                ++$number, 'getToImmutable', null,
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 23:59:59'
            ],
            [
                ++$number, 'getToImmutable', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 23:59:59'
            ],
            [
                ++$number, 'getToImmutable', null,
                new DateTime('2023-07-07 00:00:00'),
                null,
                'Y-m-d H:i:s',
                null
            ],
        ];
    }

    /**
     * Data provider (getFrom and getTo - Europe/Berlin).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderTypeDateTimeFormatEuropeBerlin(): array
    {
        $number = 0;

        return [

            /**
             * Simple tests (getFrom).
             */
            [
                ++$number, 'getFrom', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 02:00:00'
            ],
            [
                ++$number, 'getFrom', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 02:00:00'
            ],
            [
                ++$number, 'getFrom', new DateTimeZone(Timezones::EUROPE_BERLIN),
                null,
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                null
            ],

            /**
             * Simple tests (getTo).
             */
            [
                ++$number, 'getTo', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-08 01:59:59'
            ],
            [
                ++$number, 'getTo', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-08 01:59:59'
            ],
            [
                ++$number, 'getTo', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTime('2023-07-07 00:00:00'),
                null,
                'Y-m-d H:i:s',
                null
            ],
        ];
    }

    /**
     * Data provider (getFromImmutable and getToImmutable - Europe/Berlin).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderTypeDateTimeImmutableFormatEuropeBerlin(): array
    {
        $number = 0;

        return [

            /**
             * Simple tests (getFromImmutable).
             */
            [
                ++$number, 'getFromImmutable', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 02:00:00'
            ],
            [
                ++$number, 'getFromImmutable', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-07 02:00:00'
            ],
            [
                ++$number, 'getFromImmutable', new DateTimeZone(Timezones::EUROPE_BERLIN),
                null,
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                null
            ],

            /**
             * Simple tests (getToImmutable).
             */
            [
                ++$number, 'getToImmutable', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-08 01:59:59'
            ],
            [
                ++$number, 'getToImmutable', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                'Y-m-d H:i:s',
                '2023-07-08 01:59:59'
            ],
            [
                ++$number, 'getToImmutable', new DateTimeZone(Timezones::EUROPE_BERLIN),
                new DateTime('2023-07-07 00:00:00'),
                null,
                'Y-m-d H:i:s',
                null
            ],
        ];
    }
}
