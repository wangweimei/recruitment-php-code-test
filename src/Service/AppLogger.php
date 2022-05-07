<?php

namespace App\Service;

use think\facade\Log;

class AppLogger
{
    const TYPE_LOG4PHP   = 'log4php';

    const TYPE_THINK_LOG = 'think-log';

    private $logger;

    public function __construct($type = self::TYPE_LOG4PHP)
    {
        $logger = [
            self::TYPE_LOG4PHP   => new Log4PhpAppLogger(),
            self::TYPE_THINK_LOG => new ThinkLogAppLogger()
        ];

        if (!isset($logger[$type]))
        {
            throw new \Exception('Logger type not found');
        }

        $this->logger = $logger[$type];
    }

    public function info($message = '')
    {
        $this->logger->info($message);
    }

    public function debug($message = '')
    {
        $this->logger->debug($message);
    }

    public function error($message = '')
    {
        $this->logger->error($message);
    }
}

interface AppLoggerInterface
{
    public function info($message = '');
    public function debug($message = '');
    public function error($message = '');
}

class Log4PhpAppLogger implements AppLoggerInterface
{
    private $logger;

    public function __construct()
    {
        $this->logger = \Logger::getLogger("Log");
    }

    public function info($message = '')
    {
        $this->logger->info($message);
    }

    public function debug($message = '')
    {
        $this->logger->debug($message);
    }

    public function error($message = '')
    {
        $this->logger->error($message);
    }
}

class ThinkLogAppLogger implements AppLoggerInterface
{
    public function __construct()
    {
        Log::init([
            'default'    =>    'file',
            'channels'    =>    [
                'file'    =>    [
                    'type'    =>    'file',
                    'path'    =>    './logs/',
                ],
            ],
        ]);
    }

    public function info($message = '')
    {
        Log::info(strtoupper($message));
    }

    public function debug($message = '')
    {
        Log::debug(strtoupper($message));
    }

    public function error($message = '')
    {
        Log::error(strtoupper($message));
    }
}
