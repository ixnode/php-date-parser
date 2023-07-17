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
     * @dataProvider dataProviderType
     *
     * @test
     * @testdox $number) Test Range: $method
     * @param int $number
     * @param string $method
     * @param string|null $parameter
     * @param DateTime|DateTimeImmutable|null $from
     * @param DateTime|DateTimeImmutable|null $to
     * @param class-string|null $expected
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @throws CaseUnsupportedException
     */
    public function wrapperType(
        int $number,
        string $method,
        string|null $parameter,
        DateTime|DateTimeImmutable|null $from,
        DateTime|DateTimeImmutable|null $to,
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

        $result = match (true) {
            is_null($parameter) => $dateRange->{$method}(),
            default => $dateRange->{$method}($parameter),
        };

        $this->assertSame($expected, is_null($result) ? null : $result::class);
    }

    /**
     * Data provider.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderType(): array
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
                DateTime::class
            ],
            [
                ++$number, 'getFrom', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 23:59:59'),
                DateTime::class
            ],
            [
                ++$number, 'getFrom', null,
                null,
                new DateTime('2023-07-07 23:59:59'),
                null
            ],

            /**
             * Simple tests (getTo).
             */
            [
                ++$number, 'getTo', null,
                new DateTime('2023-07-07 00:00:00'),
                new DateTime('2023-07-07 00:00:00'),
                DateTime::class
            ],
            [
                ++$number, 'getTo', null,
                new DateTimeImmutable('2023-07-07 00:00:00'),
                new DateTimeImmutable('2023-07-07 00:00:00'),
                DateTime::class
            ],
            [
                ++$number, 'getTo', null,
                new DateTime('2023-07-07 00:00:00'),
                null,
                null
            ],
        ];
    }
}
