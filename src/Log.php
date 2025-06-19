<?php

namespace Totaltekst\Logger;


use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Level;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Logging\PsrLogger;

/**
 * Detailed debug information
 * Debug = 100;
 *
 * Interesting events
 *
 * Examples: User logs in, SQL logs.
 * Info = 200;
 *
 * Uncommon events
 * Notice = 250;
 *
 * Exceptional occurrences that are not errors
 *
 * Examples: Use of deprecated APIs, poor use of an API,
 * undesirable things that are not necessarily wrong.
 * Warning = 300;
 *
 * Runtime errors
 * Error = 400;
 *
 * Critical conditions
 *
 * Example: Application component unavailable, unexpected exception.
 * Critical = 500;
 *
 * Action must be taken immediately
 *
 * Example: Entire website down, database unavailable, etc.
 * This should trigger the SMS alerts and wake you up.
 * Alert = 550;
 *
 * Urgent alert.
 * Emergency = 600;
 */
class Log
{
    private static PsrLogger|Logger $logger;

    private static string $name;

    private static Level $level;

    public function __construct()
    {
    }

    static public function init_logger(string $name, Level $level, string $channel): void
    {
        self::$level = $level;
        self::$name = $name;

        if ($channel === 'google') {
            self::$logger = (new LoggingClient([
                'projectId' => getenv('GOOGLE_PROJECT_ID')
            ]))->psrLogger($name);
        } else {
            self::$logger = new Logger($name);
            self::getLogger()->pushHandler(new ErrorLogHandler(0, $level));
        }
    }

    static protected function getLogger(): PsrLogger|Logger
    {
        if (!self::$logger) {
            self::$logger = new Logger(self::$name);
            self::getLogger()->pushHandler(new ErrorLogHandler(0, self::$level));
        }

        return self::$logger;
    }


    public static function emergency(string $message, array $context = []): void
    {
        self::getLogger()->emergency($message, $context);
    }

    public static function alert(string $message, array $context = []): void
    {
        self::getLOgger()->alert($message, $context);
    }

    public static function critical(string $message, array $context = []): void
    {
        self::getLogger()->critical($message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::getLogger()->error($message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::getLogger()->warning($message, $context);
    }

    public static function notice(string $message, array $context = []): void
    {
        self::getLogger()->notice($message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::getLogger()->debug($message, $context);
    }

    public static function info(string $message, array $context = []): void
    {
        self::getLogger()->info($message, $context);
    }
}