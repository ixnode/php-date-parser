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
use DateTimeZone;
use Exception;
use Ixnode\PhpDateParser\Base\BaseDateParser;
use Ixnode\PhpDateParser\Constants\Timezones;
use Ixnode\PhpDateParser\DateParser;
use Ixnode\PhpException\Case\CaseUnsupportedException;
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
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
final class DateParserTest extends TestCase
{
    private int $number = 0;

    private const EXPECTED_PARTS_COUNT = 2;

    /**
     * Test wrapper.
     *
     * @dataProvider dataProviderNone
     * @dataProvider dataProviderDateExactly
     * @dataProvider dataProviderDateToInfinity
     * @dataProvider dataProviderInfinityToDate
     * @dataProvider dataProviderDateFromToTo
     * @dataProvider dataProviderDateTimezones
     *
     * @test
     * @testdox $dataProvider/$number) Test DateParser("$given")::$method() === "$expected";
     * @param string $dataProvider
     * @param int $number
     * @param string $method
     * @param string $parameter
     * @param string|null $given
     * @param DateTimeZone $givenTimezone
     * @param string|null $expected
     * @param DateTimeZone $expectedTimezone
     * @throws ParserException
     * @throws TypeInvalidException
     * @throws Exception
     */
    public function wrapper(
        string       $dataProvider,
        int          $number,
        string       $method,
        string       $parameter,
        string|null  $given,
        DateTimeZone $givenTimezone,
        string|null  $expected,
        DateTimeZone $expectedTimezone
    ): void
    {
        /* Arrange */

        /* Act */
        $dateParser = new DateParser($given, $givenTimezone);
        $callback = [$dateParser, $method];

        /* Assert */
        $this->assertIsNumeric($number); // To avoid phpmd warning.
        $this->assertIsString($dataProvider); // To avoid phpmd warning.
        $this->assertContains($method, get_class_methods(DateParser::class));
        $this->assertIsCallable($callback);

        $result =  $dateParser->{$method}($parameter, $expectedTimezone);

        $this->assertSame($expected, $result);
    }

    /**
     * Data provider: Parses none.
     *
     * @return array<int, array<int, mixed>>
     * @throws Exception
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
     * @throws Exception
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function dataProviderDateExactly(): array
    {
        return [

            /**
             * Parses a given date (exactly): tomorrow.
             */
            $this->getConfigFrom('tomorrow', $this->getTomorrow(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('tomorrow', $this->getTomorrow(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): tomorrow.
             */
            $this->getConfigFrom('=tomorrow', $this->getTomorrow(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=tomorrow', $this->getTomorrow(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): today.
             */
            $this->getConfigFrom('today', $this->getToday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('today', $this->getToday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): today.
             */
            $this->getConfigFrom('=today', $this->getToday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=today', $this->getToday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): yesterday.
             */
            $this->getConfigFrom('yesterday', $this->getYesterday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('yesterday', $this->getYesterday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): yesterday.
             */
            $this->getConfigFrom('=yesterday', $this->getYesterday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=yesterday', $this->getYesterday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): next-month.
             */
            $this->getConfigFrom('next-month', $this->getFirstNextMonth(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('next-month', $this->getLastNextMonth(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): next-month.
             */
            $this->getConfigFrom('=next-month', $this->getFirstNextMonth(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=next-month', $this->getLastNextMonth(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): this-month.
             */
            $this->getConfigFrom('this-month', $this->getFirstThisMonth(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('this-month', $this->getLastThisMonth(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): this-month.
             */
            $this->getConfigFrom('=this-month', $this->getFirstThisMonth(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=this-month', $this->getLastThisMonth(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): last-month.
             */
            $this->getConfigFrom('last-month', $this->getFirstLastMonth(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('last-month', $this->getLastLastMonth(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): last-month.
             */
            $this->getConfigFrom('=last-month', $this->getFirstLastMonth(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=last-month', $this->getLastLastMonth(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): next-year.
             */
            $this->getConfigFrom('next-year', $this->getFirstNextYear(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('next-year', $this->getLastNextYear(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): next-year.
             */
            $this->getConfigFrom('=next-year', $this->getFirstNextYear(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=next-year', $this->getLastNextYear(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): this-year.
             */
            $this->getConfigFrom('this-year', $this->getFirstThisYear(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('this-year', $this->getLastThisYear(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): this-year.
             */
            $this->getConfigFrom('=this-year', $this->getFirstThisYear(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=this-year', $this->getLastThisYear(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): last-year.
             */
            $this->getConfigFrom('last-year', $this->getFirstLastYear(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('last-year', $this->getLastLastYear(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given date (exactly): last-year.
             */
            $this->getConfigFrom('=last-year', $this->getFirstLastYear(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('=last-year', $this->getLastLastYear(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

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
     * @throws Exception
     */
    public function dataProviderDateToInfinity(): array
    {
        return [

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>today', $this->getTomorrow(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>today', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>=today', $this->getToday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>=today', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>+today', $this->getToday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>+today', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('+today', $this->getToday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('+today', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>yesterday', $this->getToday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>yesterday', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>=yesterday', $this->getYesterday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>=yesterday', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('>+yesterday', $this->getYesterday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('>+yesterday', null, __FUNCTION__),

            /**
             * Parses a given "from" (excluding given date) to "∞ (infinity)" date.
             */
            $this->getConfigFrom('+yesterday', $this->getYesterday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
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
     * @throws Exception
     */
    public function dataProviderInfinityToDate(): array
    {
        return [

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<today', null, __FUNCTION__),
            $this->getConfigTo('<today', $this->getYesterday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<=today', null, __FUNCTION__),
            $this->getConfigTo('<=today', $this->getToday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<+today', null, __FUNCTION__),
            $this->getConfigTo('<+today', $this->getToday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('-today', null, __FUNCTION__),
            $this->getConfigTo('-today', $this->getToday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<yesterday', null, __FUNCTION__),
            $this->getConfigTo('<yesterday', $this->getBeforeYesterday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<=yesterday', null, __FUNCTION__),
            $this->getConfigTo('<=yesterday', $this->getYesterday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('<+yesterday', null, __FUNCTION__),
            $this->getConfigTo('<+yesterday', $this->getYesterday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a "∞ (infinity)" to given "from" date (excluding given date).
             */
            $this->getConfigFrom('-yesterday', null, __FUNCTION__),
            $this->getConfigTo('-yesterday', $this->getYesterday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

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
            $this->getConfigTo('-2023-07-01', '2023-07-01 23:59:59', __FUNCTION__),
        ];
    }

    /**
     * Data provider: Parses a given "from" to "to" date.
     *
     * @return array<int, array<int, mixed>>
     * @throws Exception
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
            $this->getConfigTo('2023-07-01|tomorrow', $this->getTomorrow(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, DateParser::SECOND_LAST)->format(DateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('2023-07-01|today', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('2023-07-01|today', $this->getToday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('2023-07-01|yesterday', '2023-07-01 00:00:00', __FUNCTION__),
            $this->getConfigTo('2023-07-01|yesterday', $this->getYesterday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('yesterday|today', $this->getYesterday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('yesterday|today', $this->getToday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('yesterday|this-month', $this->getYesterday(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('yesterday|this-month', $this->getLastThisMonth(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),

            /**
             * Parses a given "from" to "to" date.
             */
            $this->getConfigFrom('this-month|today', $this->getFirstThisMonth(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
            $this->getConfigTo('this-month|today', $this->getToday(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__),
        ];
    }

    /**
     * Data provider: Parses a given date with timezones.
     *
     * @return array<int, array<int, mixed>>
     * @throws Exception
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function dataProviderDateTimezones(): array
    {
        $data = [];

        /**
         * Parses a given date (exactly): 2023-07-01 (UTC -> UTC).
         */
        $data[] = $this->getConfigFrom('2023-07-01::UTC', '2023-07-01 00:00:00', __FUNCTION__);
        $data[] = $this->getConfigTo('2023-07-01::UTC', '2023-07-01 23:59:59', __FUNCTION__);

        /**
         * Parses a given date (exactly): 2023-07-01 (UTC -> UTC).
         */
        $data[] = $this->getConfigFrom('2023-07-01::UTC', '2023-07-01 00:00:00::UTC', __FUNCTION__);
        $data[] = $this->getConfigTo('2023-07-01::UTC', '2023-07-01 23:59:59::UTC', __FUNCTION__);

        /**
         * Parses a given date (exactly): 2023-07-01 (Europe/Berlin -> UTC).
         */
        $data[] = $this->getConfigFrom('2023-07-01::Europe/Berlin', '2023-06-30 22:00:00::UTC', __FUNCTION__);
        $data[] = $this->getConfigTo('2023-07-01::Europe/Berlin', '2023-07-01 21:59:59::UTC', __FUNCTION__);

        /**
         * Parses a given date (exactly): 2023-07-01 (UTC -> Europe/Berlin).
         */
        $data[] = $this->getConfigFrom('2023-07-01::UTC', '2023-07-01 02:00:00::Europe/Berlin', __FUNCTION__);
        $data[] = $this->getConfigTo('2023-07-01::UTC', '2023-07-02 01:59:59::Europe/Berlin', __FUNCTION__);

        /**
         * Parses a given date (exactly): 2023-07-01 (America/New_York -> UTC).
         */
        $data[] = $this->getConfigFrom('2023-07-01::America/New_York', '2023-07-01 04:00:00::UTC', __FUNCTION__);
        $data[] = $this->getConfigTo('2023-07-01::America/New_York', '2023-07-02 03:59:59::UTC', __FUNCTION__);

        /**
         * Parses a given date (exactly): 2023-07-01 (UTC -> America/New_York).
         */
        $data[] = $this->getConfigFrom('2023-07-01::UTC', '2023-06-30 20:00:00::America/New_York', __FUNCTION__);
        $data[] = $this->getConfigTo('2023-07-01::UTC', '2023-07-01 19:59:59::America/New_York', __FUNCTION__);

        /**
         * Parses a given date (exactly): 2023-07-01 (America/New_York -> Europe/Berlin).
         */
        $data[] = $this->getConfigFrom('2023-07-01::America/New_York', '2023-07-01 06:00:00::Europe/Berlin', __FUNCTION__);
        $data[] = $this->getConfigTo('2023-07-01::America/New_York', '2023-07-02 05:59:59::Europe/Berlin', __FUNCTION__);

        /**
         * Parses a given date (exactly): 2023-07-01 (Europe/Berlin -> America/New_York).
         */
        $data[] = $this->getConfigFrom('2023-07-01::Europe/Berlin', '2023-06-30 18:00:00::America/New_York', __FUNCTION__);
        $data[] = $this->getConfigTo('2023-07-01::Europe/Berlin', '2023-07-01 17:59:59::America/New_York', __FUNCTION__);

        /**
         * Parses a given date (exactly): tomorrow (UTC -> UTC).
         */
        $data[] = $this->getConfigFrom('tomorrow', $this->getTomorrow(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__);
        $data[] = $this->getConfigTo('tomorrow', $this->getTomorrow(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__);

        /**
         * Parses a given date (exactly): tomorrow (UTC -> UTC).
         */
        $timezoneFrom = new DateTimeZone(Timezones::UTC);
        $data[] = $this->getConfigFrom('tomorrow::UTC', $this->getTomorrow(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST, $timezoneFrom)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__);
        $data[] = $this->getConfigTo('tomorrow::UTC', $this->getTomorrow(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST, $timezoneFrom)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__);

        /**
         * Parses a given date (exactly): tomorrow (Europe/Berlin -> UTC).
         */
        $timezoneFrom = new DateTimeZone(Timezones::EUROPE_BERLIN);
        $data[] = $this->getConfigFrom('tomorrow::Europe/Berlin', $this->getTomorrow(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST, $timezoneFrom)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__);
        $data[] = $this->getConfigTo('tomorrow::Europe/Berlin', $this->getTomorrow(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST, $timezoneFrom)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__);

        /**
         * Parses a given date (exactly): tomorrow (America/New_York -> UTC).
         */
        $timezoneFrom = new DateTimeZone(Timezones::AMERICA_NEW_YORK);
        $data[] = $this->getConfigFrom('tomorrow::America/New_York', $this->getTomorrow(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST, $timezoneFrom)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__);
        $data[] = $this->getConfigTo('tomorrow::America/New_York', $this->getTomorrow(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST, $timezoneFrom)->format(BaseDateParser::FORMAT_DEFAULT), __FUNCTION__);

        /**
         * Parses a given date (exactly): tomorrow (Europe/Berlin -> Europe/Berlin).
         */
        $given = 'tomorrow';
        $timezoneFrom = new DateTimeZone(Timezones::EUROPE_BERLIN);
        $timezoneTo = new DateTimeZone(Timezones::EUROPE_BERLIN);
        $expectedFrom = $this->getTomorrow(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST, $timezoneFrom, $timezoneTo)->format(BaseDateParser::FORMAT_DEFAULT);
        $expectedTo = $this->getTomorrow(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST, $timezoneFrom, $timezoneTo)->format(BaseDateParser::FORMAT_DEFAULT);
        $data[] = $this->getConfigFromTimezone($given, $expectedFrom, $timezoneFrom, $timezoneTo, __FUNCTION__);
        $data[] = $this->getConfigToTimezone($given, $expectedTo, $timezoneFrom, $timezoneTo, __FUNCTION__);

        /**
         * Parses a given date (exactly): tomorrow (Europe/Berlin -> America/New_York).
         */
        $given = 'tomorrow';
        $timezoneFrom = new DateTimeZone(Timezones::EUROPE_BERLIN);
        $timezoneTo = new DateTimeZone(Timezones::AMERICA_NEW_YORK);
        $expectedFrom = $this->getTomorrow(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST, $timezoneFrom, $timezoneTo)->format(BaseDateParser::FORMAT_DEFAULT);
        $expectedTo = $this->getTomorrow(BaseDateParser::HOUR_LAST, BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST, $timezoneFrom, $timezoneTo)->format(BaseDateParser::FORMAT_DEFAULT);
        $data[] = $this->getConfigFromTimezone($given, $expectedFrom, $timezoneFrom, $timezoneTo, __FUNCTION__);
        $data[] = $this->getConfigToTimezone($given, $expectedTo, $timezoneFrom, $timezoneTo, __FUNCTION__);

        return $data;
    }

    /**
     * Returns the value and timezone parts.
     *
     * @param string|null $value
     * @return array{value: string|null, timezone: DateTimeZone}
     * @throws Exception
     */
    private function getParts(string|null $value): array
    {
        $defaultTimezone = Timezones::UTC;

        if (is_null($value)) {
            return [
                'value' => null,
                'timezone' => new DateTimeZone($defaultTimezone),
            ];
        }

        $valueExploded = explode('::', $value);

        if (count($valueExploded) < self::EXPECTED_PARTS_COUNT) {
            return [
                'value' => $value,
                'timezone' => new DateTimeZone($defaultTimezone),
            ];
        }

        return [
            'value' => $valueExploded[0],
            'timezone' => new DateTimeZone($valueExploded[1]),
        ];
    }

    /**
     * Returns the config for "from" range.
     *
     * @param string|null $range
     * @param string|null $expected
     * @param string $method
     * @return array<int, mixed>
     * @throws Exception
     */
    private function getConfigFrom(string|null $range, string|null $expected, string $method): array
    {
        ['value' => $rangeValue, 'timezone' => $rangeTimezone] = $this->getParts($range);
        ['value' => $expectedValue, 'timezone' => $expectedTimezone] = $this->getParts($expected);

        return [
            $method,
            ++$this->number,
            'formatFrom',
            BaseDateParser::FORMAT_DEFAULT,
            $rangeValue,
            $rangeTimezone,
            $expectedValue,
            $expectedTimezone
        ];
    }

    /**
     * Returns the config for "from" range with timezone.
     *
     * @param string|null $range
     * @param string|null $expected
     * @param DateTimeZone $timezoneFrom
     * @param DateTimeZone $timezoneTo
     * @param string $method
     * @return array<int, mixed>
     * @throws Exception
     */
    private function getConfigFromTimezone(
        string|null $range,
        string|null $expected,
        DateTimeZone $timezoneFrom,
        DateTimeZone $timezoneTo,
        string $method
    ): array
    {
        return $this->getConfigFrom(
            is_null($range) ? null : sprintf('%s::%s', $range, $timezoneFrom->getName()),
            is_null($expected) ? null : sprintf('%s::%s', $expected, $timezoneTo->getName()),
            $method
        );
    }

    /**
     * Returns the config for "to" range.
     *
     * @param string|null $range
     * @param string|null $expected
     * @param string $method
     * @return array<int, mixed>
     * @throws Exception
     */
    private function getConfigTo(string|null $range, string|null $expected, string $method): array
    {
        ['value' => $rangeValue, 'timezone' => $rangeTimezone] = $this->getParts($range);
        ['value' => $expectedValue, 'timezone' => $expectedTimezone] = $this->getParts($expected);

        return [
            $method,
            ++$this->number,
            'formatTo',
            BaseDateParser::FORMAT_DEFAULT,
            $rangeValue,
            $rangeTimezone,
            $expectedValue,
            $expectedTimezone
        ];
    }

    /**
     * Returns the config for "to" range with timezone.
     *
     * @param string|null $range
     * @param string|null $expected
     * @param DateTimeZone $timezoneFrom
     * @param DateTimeZone $timezoneTo
     * @param string $method
     * @return array<int, mixed>
     * @throws Exception
     */
    private function getConfigToTimezone(
        string|null $range,
        string|null $expected,
        DateTimeZone $timezoneFrom,
        DateTimeZone $timezoneTo,
        string $method
    ): array
    {
        return $this->getConfigTo(
            is_null($range) ? null : sprintf('%s::%s', $range, $timezoneFrom->getName()),
            is_null($expected) ? null : sprintf('%s::%s', $expected, $timezoneTo->getName()),
            $method
        );
    }

    /**
     * Returns the tomorrow date with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws CaseUnsupportedException
     */
    private function getTomorrow(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(BaseDateParser::VALUE_TOMORROW))
            ->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the today date with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws CaseUnsupportedException
     */
    private function getToday(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime= (new DateTime())->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the yesterday date with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws CaseUnsupportedException
     */
    private function getYesterday(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(BaseDateParser::VALUE_YESTERDAY))->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the before yesterday date with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws CaseUnsupportedException
     */
    private function getBeforeYesterday(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime())->sub(new DateInterval('P2D'))->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of this month with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws CaseUnsupportedException
     * @throws Exception
     */
    private function getFirstNextMonth(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(date(BaseDateParser::FORMAT_THIS_MONTH_LAST)))
            ->setTime(BaseDateParser::HOUR_LAST,BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)
            ->modify('+1 second')
            ->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of this month with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws CaseUnsupportedException
     * @throws Exception
     */
    private function getLastNextMonth(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $firstNextMonth = $this->getFirstNextMonth($hour, $minute, $second);

        $dateTime = (new DateTime($firstNextMonth->format(BaseDateParser::FORMAT_THIS_MONTH_LAST)))
            ->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of this month with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getFirstThisMonth(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(date(BaseDateParser::FORMAT_THIS_MONTH_FIRST)))->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of this month with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getLastThisMonth(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(date(BaseDateParser::FORMAT_THIS_MONTH_LAST)))->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of the last month with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getFirstLastMonth(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $lastLastMonth = $this->getLastLastMonth($hour, $minute, $second);

        $dateTime = (new DateTime($lastLastMonth->format(BaseDateParser::FORMAT_THIS_MONTH_FIRST)))
            ->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of the last month with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getLastLastMonth(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(date(BaseDateParser::FORMAT_THIS_MONTH_FIRST)))
            ->setTime(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)
            ->modify('-1 second')
            ->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of the next year with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getFirstNextYear(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(date(BaseDateParser::FORMAT_THIS_YEAR_LAST)))
            ->setTime(BaseDateParser::HOUR_LAST,BaseDateParser::MINUTE_LAST, BaseDateParser::SECOND_LAST)
            ->modify('+1 second')
            ->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the last day of the next year with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getLastNextYear(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $firstNextYear = $this->getFirstNextYear($hour, $minute, $second);

        $dateTime = (new DateTime($firstNextYear->format(BaseDateParser::FORMAT_THIS_YEAR_LAST)))
            ->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of this year with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getFirstThisYear(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(date(BaseDateParser::FORMAT_THIS_YEAR_FIRST)))->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of this year with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getLastThisYear(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(date(BaseDateParser::FORMAT_THIS_YEAR_LAST)))->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the first day of the last year with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getFirstLastYear(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $lastLastYear = $this->getLastLastYear($hour, $minute, $second);

        $dateTime = (new DateTime($lastLastYear->format(BaseDateParser::FORMAT_THIS_YEAR_FIRST)))
            ->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns the last day of the last year with the given time.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param DateTimeZone $dateTimeZoneSource
     * @param DateTimeZone $dateTimeZoneTarget
     * @return DateTime
     * @throws Exception
     */
    private function getLastLastYear(
        int $hour,
        int $minute,
        int $second,
        DateTimeZone $dateTimeZoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $dateTimeZoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        $dateTime = (new DateTime(date(BaseDateParser::FORMAT_THIS_YEAR_FIRST)))
            ->setTime(BaseDateParser::HOUR_FIRST, BaseDateParser::MINUTE_FIRST, BaseDateParser::SECOND_FIRST)
            ->modify('-1 second')
            ->setTime($hour, $minute, $second);

        return $this->convertDateTimeZone(
            $this->convertDateTimeZone($dateTime, $dateTimeZoneSource),
            new DateTimeZone(Timezones::UTC),
            $dateTimeZoneTarget
        );
    }

    /**
     * Returns a DateTime instance with timezone UTC.
     *
     * @param DateTime $dateTimeSource
     * @param DateTimeZone $timezoneSource
     * @param DateTimeZone $timezoneTarget
     * @return DateTime
     * @throws CaseUnsupportedException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function convertDateTimeZone(
        DateTime $dateTimeSource,
        DateTimeZone $timezoneSource = new DateTimeZone(Timezones::UTC),
        DateTimeZone $timezoneTarget = new DateTimeZone(Timezones::UTC)
    ): DateTime
    {
        if ($timezoneTarget->getName() === $timezoneSource->getName()) {
            return $dateTimeSource;
        }

        $dateTimeWithTimezone = DateTime::createFromFormat(
            BaseDateParser::FORMAT_DEFAULT,
            $dateTimeSource->format(BaseDateParser::FORMAT_DEFAULT),
            $timezoneSource
        );

        if ($dateTimeWithTimezone === false) {
            throw new CaseUnsupportedException('Unable to create DateTime format.');
        }

        $dateTimeWithTimezone->setTimezone($timezoneTarget);

        return $dateTimeWithTimezone;
    }
}
