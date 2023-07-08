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

use DateInterval;
use DateTime;
use Ixnode\PhpDateParser\DateParser;
use Ixnode\PhpException\Parser\ParserException;
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
    private int $number = 0;

    /**
     * Test wrapper.
     *
     * @dataProvider dataProviderNone
     * @dataProvider dataProviderDateExactly
     * @dataProvider dataProviderDateToInfinity
     * @dataProvider dataProviderInfinityToDate
     * @dataProvider dataProviderDateFromToTo
     *
     * @test
     * @testdox $dataProvider/$number) Test DateParser("$given")::$method() === "$expected";
     * @param string $dataProvider
     * @param int $number
     * @param string $method
     * @param string|null $parameter
     * @param string|null $given
     * @param string|null $expected
     * @throws ParserException
     * @throws TypeInvalidException
     */
    public function wrapper(
        string $dataProvider,
        int $number,
        string $method,
        string|null $parameter,
        string|null $given,
        string|null $expected
    ): void
    {
        /* Arrange */

        /* Act */
        $dateParser = new DateParser($given);
        $callback = [$dateParser, $method];

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertIsString($dataProvider); // To avoid phpmd warning.
        $this->assertContains($method, get_class_methods(DateParser::class));
        $this->assertIsCallable($callback);

        $result = match (true) {
            is_null($parameter) => $dateParser->{$method}(),
            default => $dateParser->{$method}($parameter),
        };

        $this->assertSame($expected, $result);
    }

    /**
     * Data provider: Parses none.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderNone(): array
    {
        return [
            $this->getConfigFrom(null, null, __FUNCTION__),
            $this->getConfigTo(null, null, __FUNCTION__),
        ];
    }

    /**
     * Data provider: Parses a given date (exactly).
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderDateExactly(): array
    {
        return [

            /**
             * Parses a given date (exactly): tomorrow.
             */
            $this->getConfigFrom('tomorrow', $this->getTomorrow(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('tomorrow', $this->getTomorrow(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): tomorrow.
             */
            $this->getConfigFrom('=tomorrow', $this->getTomorrow(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=tomorrow', $this->getTomorrow(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): today.
             */
            $this->getConfigFrom('today', $this->getToday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('today', $this->getToday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): today.
             */
            $this->getConfigFrom('=today', $this->getToday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=today', $this->getToday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): yesterday.
             */
            $this->getConfigFrom('yesterday', $this->getYesterday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('yesterday', $this->getYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): yesterday.
             */
            $this->getConfigFrom('=yesterday', $this->getYesterday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=yesterday', $this->getYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly).
             */
            $this->getConfigFrom('2023-07-01', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('2023-07-01', '2023-07-01 23:59:59', __FUNCTION__),

            /**
             * Parses a given date (exactly).
             */
            $this->getConfigFrom('=2023-07-01', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('=2023-07-01', '2023-07-01 23:59:59', __FUNCTION__),
        ];
    }

    /**
     * Data provider: Parses a given "from" to "∞ (infinity)" date.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderDateToInfinity(): array
    {
        return [

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>today', $this->getTomorrow(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>today', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>=today', $this->getToday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>=today', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>+today', $this->getToday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>+today', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('+today', $this->getToday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('+today', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>yesterday', $this->getToday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>yesterday', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>=yesterday', $this->getYesterday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>=yesterday', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>+yesterday', $this->getYesterday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>+yesterday', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('+yesterday', $this->getYesterday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('+yesterday', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>2023-07-01', '2023-07-02 00:00:00', __FUNCTION__),
            $this->getConfigTo('>2023-07-01', null, __FUNCTION__),

            /**
             * Parses a given "from" (including given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>=2023-07-01', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('>=2023-07-01', null, __FUNCTION__),

            /**
             * Parses a given "from" (including given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>+2023-07-01', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('>+2023-07-01', null, __FUNCTION__),

            /**
             * Parses a given "from" (including given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('+2023-07-01', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('+2023-07-01', null, __FUNCTION__),
        ];
    }

    /**
     * Data provider: Parses a "∞ (infinity)" to given "from" date.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderInfinityToDate(): array
    {
        return [

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<today', null, __FUNCTION__),
            $this->getConfigTo('<today', $this->getYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<=today', null, __FUNCTION__),
            $this->getConfigTo('<=today', $this->getToday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<+today', null, __FUNCTION__),
            $this->getConfigTo('<+today', $this->getToday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('-today', null, __FUNCTION__),
            $this->getConfigTo('-today', $this->getToday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<yesterday', null, __FUNCTION__),
            $this->getConfigTo('<yesterday', $this->getBeforeYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<=yesterday', null, __FUNCTION__),
            $this->getConfigTo('<=yesterday', $this->getYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<+yesterday', null, __FUNCTION__),
            $this->getConfigTo('<+yesterday', $this->getYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('-yesterday', null, __FUNCTION__),
            $this->getConfigTo('-yesterday', $this->getYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<2023-07-01', null, __FUNCTION__),
            $this->getConfigTo('<2023-07-01', '2023-06-30 23:59:59', __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<=2023-07-01', null, __FUNCTION__),
            $this->getConfigTo('<=2023-07-01', '2023-07-01 23:59:59', __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (including given date).
             */
            $this->getConfigFrom('<+2023-07-01', null, __FUNCTION__),
            $this->getConfigTo('<+2023-07-01', '2023-07-01 23:59:59', __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (including given date).
             */
            $this->getConfigFrom('-2023-07-01', null, __FUNCTION__),
            [__FUNCTION__, ++$this->number, 'formatTo', DateParser::FORMAT_DEFAULT, '-2023-07-01', '2023-07-01 23:59:59'],
        ];
    }

    /**
     * Data provider: Parses a given "from" to "to" date.
     *
     * @return array<int, array<int, mixed>>
     */
    public function dataProviderDateFromToTo(): array
    {
        return [
            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('2023-07-01|2023-07-03', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('2023-07-01|2023-07-03', '2023-07-03 23:59:59', __FUNCTION__),

            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('2023-07-01|tomorrow', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('2023-07-01|tomorrow', $this->getTomorrow(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('2023-07-01|today', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('2023-07-01|today', $this->getToday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('2023-07-01|yesterday', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('2023-07-01|yesterday', $this->getYesterday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('yesterday|today', $this->getYesterday(DateParser::HOUR_FIRST, DateParser::MINUTE_FIRST, DateParser::SECOND_FIRST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('yesterday|today', $this->getToday(DateParser::HOUR_LAST, DateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),
        ];
    }

    /**
     * Returns the config for "from" range.
     *
     * @param string|null $range
     * @param string|null $expected
     * @param string $method
     * @return array<int, mixed>
     */
    private function getConfigFrom(string|null $range, string|null $expected, string $method): array
    {
        return [$method, ++$this->number, 'formatFrom', DateParser::FORMAT_DEFAULT, $range, $expected];
    }

    /**
     * Returns the config for "to" range.
     *
     * @param string|null $range
     * @param string|null $expected
     * @param string $method
     * @return array<int, mixed>
     */
    private function getConfigTo(string|null $range, string|null $expected, string $method): array
    {
        return [$method, ++$this->number, 'formatTo', DateParser::FORMAT_DEFAULT, $range, $expected];
    }

    /**
     * Returns the tomorrow date with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return DateTime
     */
    private function getTomorrow(int $hour, int $minute, int $second): DateTime
    {
        return (new DateTime(DateParser::VALUE_TOMORROW))->setTime($hour, $minute, $second);
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
     * Returns the yesterday date with the given time.
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

    /**
     * Returns the before yesterday date with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return DateTime
     */
    private function getBeforeYesterday(int $hour, int $minute, int $second): DateTime
    {
        return (new DateTime())->sub(new DateInterval('P2D'))->setTime($hour, $minute, $second);
    }
}
