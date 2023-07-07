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
use Ixnode\PhpDateParser\DateParser;
use Ixnode\PhpException\Type\TypeInvalidException;
use PHPUnit\Framework\TestCase;

/**
 * Class DateParserTest
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-06-30)
 * @since 0.1.0 (2023-06-30) First version.
 * @link DateParser
 */
final class DateParserTest extends TestCase
{
    /**
     * Test wrapper.
     *
     * @dataProvider dataProvider
     *
     * @test
     * @testdox $number) Test Country: $method
     * @param int $number
     * @param string $method
     * @param string|null $parameter
     * @param string $given
     * @param string|null $expected
     * @throws TypeInvalidException
     */
    public function wrapper(
        int $number,
        string $method,
        string|null $parameter,
        string $given,
        string|null $expected
    ): void
    {
        /* Arrange */

        /* Act */
        $dateParser = new DateParser($given);
        $callback = [$dateParser, $method];

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertContains($method, get_class_methods(DateParser::class));
        $this->assertIsCallable($callback);

        $result = match (true) {
            is_null($parameter) => $dateParser->{$method}(),
            default => $dateParser->{$method}($parameter),
        };

        $this->assertSame($expected, $result);
    }

    /**
     * Data provider.
     *
     * @return array<int, array<int, string|int|null>>
     */
    public function dataProvider(): array
    {
        $number = 0;

        return [

            /**
             * Parses "today" date.
             */
            [
                ++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, DateParser::VALUE_TODAY,
                $this->getToday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT)
            ],
            [
                ++$number, 'formatTo', DateParser::FORMAT_DEFAULT, DateParser::VALUE_TODAY,
                $this->getToday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT)
            ],

            /**
             * Parses "yesterday" date.
             */
            [
                ++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, DateParser::VALUE_YESTERDAY,
                $this->getYesterday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT)
            ],
            [
                ++$number, 'formatTo', DateParser::FORMAT_DEFAULT, DateParser::VALUE_YESTERDAY,
                $this->getYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT)
            ],

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            [++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, '<2023-07-01', null],
            [++$number, 'formatTo', DateParser::FORMAT_DEFAULT, '<2023-07-01', '2023-06-30 23:59:59'],

            /**
             * Parses a "∞ (infinity)" to given "from" date (including given date).
             */
            [++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, '<+2023-07-01', null],
            [++$number, 'formatTo', DateParser::FORMAT_DEFAULT, '<+2023-07-01', '2023-07-01 23:59:59'],

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            [++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, '>2023-07-01', '2023-07-02 00:00:00'],
            [++$number, 'formatTo', DateParser::FORMAT_DEFAULT, '>2023-07-01', null],

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            [++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, '>+2023-07-01', '2023-07-01 00:00:00'],
            [++$number, 'formatTo', DateParser::FORMAT_DEFAULT, '>+2023-07-01', null],

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            [++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, '+2023-07-01', '2023-07-01 00:00:00'],
            [++$number, 'formatTo', DateParser::FORMAT_DEFAULT, '+2023-07-01', null],

            /**
             * Parses a given date (exactly).
             */
            [++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, '2023-07-01', '2023-07-01 00:00:00'],
            [++$number, 'formatTo', DateParser::FORMAT_DEFAULT, '2023-07-01', '2023-07-01 23:59:59'],

            /**
             * Parses a given "from" to "to" date.
             */
            [++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, '2023-07-01|2023-07-03', '2023-07-01 00:00:00'],
            [++$number, 'formatTo', DateParser::FORMAT_DEFAULT, '2023-07-01|2023-07-03', '2023-07-03 23:59:59'],

            /**
             * Parses a given "from" to "to" date.
             */
            [++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, '2023-07-01|today', '2023-07-01 00:00:00'],
            [++$number, 'formatTo', DateParser::FORMAT_DEFAULT, '2023-07-01|today', $this->getToday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT)],

            /**
             * Parses a given "from" to "to" date.
             */
            [++$number, 'formatFrom', DateParser::FORMAT_DEFAULT, '2023-07-01|yesterday', '2023-07-01 00:00:00'],
            [++$number, 'formatTo', DateParser::FORMAT_DEFAULT, '2023-07-01|yesterday', $this->getYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT)],
        ];
    }

    /**
     * Returns the today date with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return DateTime
     */
    private function getToday(int $hour, int $minute, int $second): DateTime
    {
        return (new DateTime())->setTime($hour, $minute, $second);
    }

    /**
     * Returns the today date with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return DateTime
     */
    private function getYesterday(int $hour, int $minute, int $second): DateTime
    {
        return (new DateTime(DateParser::VALUE_YESTERDAY))->setTime($hour, $minute, $second);
    }
}
