<?php

namespace Totaltekst\Logger;


use Exception;
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
     * @param string|null    $google_project_id
     *
     * @return void
     * @throws \Exception
     */
    static public function init_logger(string $name, Level $level = Level::Debug, string $channel = 'errorlog', ?string $google_project_id = null): void
    {
        self::$level = $level;
        self::$name = $name;

        if ($channel === 'google') {
            if ($google_project_id) {
                $err = 'Google project id is not set!';
                $err .= 'To log to Google logging, please provide the google project id.';
                throw new Exception($err);
            }
            self::$logger = (new LoggingClient([
                'projectId' => $google_project_id
            ]))->psrLogger($name);
        } elseif ($channel === 'errorlog') {
            self::$logger = new Logger($name);
            self::getLogger()->pushHandler(new ErrorLogHandler(0, $level));
        } else {
            throw new Exception('Un-supported log channel: ' . $channel);
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