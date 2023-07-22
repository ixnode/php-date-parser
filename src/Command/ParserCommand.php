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

namespace Ixnode\PhpDateParser\Command;

use Ahc\Cli\Application as App;
use Ahc\Cli\Input\Command;
use Ahc\Cli\Output\Color;
use Ahc\Cli\Output\Writer;
use DateTimeZone;
use Exception;
use Ixnode\PhpDateParser\Constants\Timezones;
use Ixnode\PhpDateParser\DateParser;
use Ixnode\PhpException\Case\CaseUnsupportedException;
use Ixnode\PhpException\Parser\ParserException;
use Ixnode\PhpException\Type\TypeInvalidException;

/**
 * Class ParserCommand
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-07-20)
 * @since 0.1.0 (2023-07-20) First version.
 * @property string|null $dateTimeRange
 */
class ParserCommand extends Command
{
    private const SUCCESS = 0;

    private const INVALID = 2;

    private const TEXT_NOT_AVAILABLE = 'n/a';

    private const DATA_FORMAT_DEFAULT = 'Y-m-d H:i:s';

    private const KEY_FORMAT = 'format';

    private const KEY_GIVEN = 'given';

    private const KEY_TYPE = 'type';

    private const KEY_VALUE = 'value';

    private const VALUE_FROM = 'From';

    private const VALUE_TO = 'To';

    private const CONFIG_TABLE = [
        'head' => 'boldGreen',
        'odd'  => 'bold',
        'even' => 'bold',
    ];

    private Writer $writer;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('parse:date-time', 'Parses given date time string.');

        $this
            ->argument('date-time-range', 'The date time range string to parse.')
            ->option('-tzi --timezone-input', 'The timezone (input)', null, 'UTC')
            ->option('-tzo --timezone-output', 'The timezone (output)', null, 'UTC')
        ;
    }

    /**
     * @param string $dateTimeRange
     * @param DateTimeZone $timezoneInput
     * @param DateTimeZone $timezoneOutput
     * @return void
     */
    private function printGivenDateTimeRange(string $dateTimeRange, DateTimeZone $timezoneInput, DateTimeZone$timezoneOutput): void
    {
        $writer = $this->writer();
        $color = new Color();

        $writer->write(PHP_EOL);
        $writer->write(sprintf(
            'Given date time range: %s (%s > %s)%s',
            $color->ok(sprintf('"%s"', $dateTimeRange)),
            $timezoneInput->getName(),
            $timezoneOutput->getName(),
            PHP_EOL
        ));
        $writer->write(PHP_EOL);
        $writer->table([
            [
                self::KEY_VALUE => sprintf(
                    'Given date time range (%s > %s)',
                    $timezoneInput->getName(),
                    $timezoneOutput->getName()
                ),
                self::KEY_GIVEN => $dateTimeRange,
            ],
            [
                self::KEY_VALUE => 'Timezone (input)',
                self::KEY_GIVEN => $timezoneInput->getName(),
            ],
            [
                self::KEY_VALUE => 'Timezone (output)',
                self::KEY_GIVEN => $timezoneOutput->getName(),
            ]
        ], self::CONFIG_TABLE);
    }

    /**
     * Returns "from" array.
     *
     * @param DateParser $dateParser
     * @param DateTimeZone $timezone
     * @return array<string, string>
     * @throws CaseUnsupportedException
     */
    private function getFromArray(DateParser $dateParser, DateTimeZone $timezone): array
    {
        $timezoneLocal = $timezone->getName();

        $fromArray = [
            self::KEY_TYPE => self::VALUE_FROM,
            self::KEY_FORMAT => self::DATA_FORMAT_DEFAULT,
        ];

        if ($timezone->getName() !== Timezones::UTC) {
            $fromArray[Timezones::UTC] = $dateParser->getFrom()?->format(self::DATA_FORMAT_DEFAULT) ?: self::TEXT_NOT_AVAILABLE;
        }

        $fromArray[$timezoneLocal] = $dateParser->getFrom($timezone)?->format(self::DATA_FORMAT_DEFAULT) ?: self::TEXT_NOT_AVAILABLE;

        return $fromArray;
    }

    /**
     * Returns "to" array.
     *
     * @param DateParser $dateParser
     * @param DateTimeZone $timezone
     * @return array<string, string>
     * @throws CaseUnsupportedException
     */
    private function getToArray(DateParser $dateParser, DateTimeZone $timezone): array
    {
        $timezoneLocal = $timezone->getName();

        $toArray = [
            self::KEY_TYPE => self::VALUE_TO,
            self::KEY_FORMAT => self::DATA_FORMAT_DEFAULT,
        ];

        if ($timezone->getName() !== Timezones::UTC) {
            $toArray[Timezones::UTC] = $dateParser->getTo()?->format(self::DATA_FORMAT_DEFAULT) ?: self::TEXT_NOT_AVAILABLE;
        }

        $toArray[$timezoneLocal] = $dateParser->getTo($timezone)?->format(self::DATA_FORMAT_DEFAULT) ?: self::TEXT_NOT_AVAILABLE;

        return $toArray;
    }

    /**
     * @param DateParser $dateParser
     * @param DateTimeZone $timezone
     * @param string $title
     * @return void
     * @throws CaseUnsupportedException
     */
    private function printData(DateParser $dateParser, DateTimeZone $timezone, string $title): void
    {
        $fromArray = $this->getFromArray($dateParser, $timezone);
        $toArray = $this->getToArray($dateParser, $timezone);

        $this->writer->write(PHP_EOL);
        $this->writer->write(sprintf('%s:%s', $title, PHP_EOL));
        $this->writer->write(PHP_EOL);
        $this->writer->table([$fromArray, $toArray], self::CONFIG_TABLE);
    }

    /**
     * Prints error message.
     *
     * @param string $message
     * @return void
     * @throws Exception
     */
    private function printError(string $message): void
    {
        $color = new Color();

        $this->writer->write(sprintf('%s%s', $color->error($message), PHP_EOL));
    }

    /**
     * Executes the ParserCommand.
     *
     * @param string $timezoneInput
     * @param string $timezoneOutput
     * @return int
     * @throws ParserException
     * @throws TypeInvalidException
     * @throws Exception
     */
    public function execute(string $timezoneInput, string $timezoneOutput): int
    {
        $this->writer = $this->writer();

        $timezoneInput = new DateTimeZone($timezoneInput);
        $timezoneOutput = new DateTimeZone($timezoneOutput);

        $dateTimeRange = $this->dateTimeRange;

        if (is_null($dateTimeRange)) {
            $this->printError('No date time range given.');
            return self::INVALID;
        }

        $dateParser = (new DateParser($dateTimeRange, $timezoneInput));

        $duration = $dateParser->getDurationWithOwn();

        $messageInput = match (true) {
            is_null($duration) => 'Parsed from given input string (duration: infinite)',
            default => sprintf('Parsed from given input string (duration: %d seconds)', $duration),
        };
        $messageOutput = match (true) {
            is_null($duration) => 'Parsed output (duration: infinite)',
            default => sprintf('Parsed output (duration: %d seconds)', $duration),
        };

        $this->printGivenDateTimeRange($dateTimeRange, $timezoneInput, $timezoneOutput);
        $this->printData($dateParser, $timezoneInput, $messageInput);
        $this->printData($dateParser, $timezoneOutput, $messageOutput);
        $this->writer->write(PHP_EOL);

        return self::SUCCESS;
    }
}
