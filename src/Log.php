<?php

namespace Totaltekst\Logger;


use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Level;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\Logging\PsrLogger;

/**
 *
 */
class Log
{
    private static PsrLogger|Logger $logger;

    private static string $name;

    private static Level $level;

    public function __construct()
    {

    }

    /**
     * Initialise the logger interface
     *
     * @param string         $name
     * @param \Monolog\Level $level
     * @param string         $channel (use 'errorlog' fpr local dev logging, 'google' for logging in google)
     *
     * @return void
     */
    static public function init_logger(string $name, Level $level = Level::Debug, string $channel = 'errorlog'): void
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

    /**
     * @return \Google\Cloud\Logging\PsrLogger|\Monolog\Logger
     */
    static protected function getLogger(): PsrLogger|Logger
    {
        if (!self::$logger) {
            self::$logger = new Logger(self::$name);
            self::getLogger()->pushHandler(new ErrorLogHandler(0, self::$level));
        }

        return self::$logger;
    }


    /**
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public static function emergency(string $message, array $context = []): void
    {
        self::getLogger()->emergency($message, $context);
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public static function alert(string $message, array $context = []): void
    {
        self::getLOgger()->alert($message, $context);
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public static function critical(string $message, array $context = []): void
    {
        self::getLogger()->critical($message, $context);
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public static function error(string $message, array $context = []): void
    {
        self::getLogger()->error($message, $context);
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public static function warning(string $message, array $context = []): void
    {
        self::getLogger()->warning($message, $context);
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public static function notice(string $message, array $context = []): void
    {
        self::getLogger()->notice($message, $context);
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public static function debug(string $message, array $context = []): void
    {
        self::getLogger()->debug($message, $context);
    }

    /**
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public static function info(string $message, array $context = []): void
    {
        self::getLogger()->info($message, $context);
    }
}