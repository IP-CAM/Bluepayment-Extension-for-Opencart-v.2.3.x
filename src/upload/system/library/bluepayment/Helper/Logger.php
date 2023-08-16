<?php

namespace BluePayment\Helper;

require_once DIR_SYSTEM . '/library/bluemedia-sdk-php/index.php';

use Registry;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

final class Logger
{
    const LOG_NAME = 'Autopay';
    const LOG_FILENAME = '/bluepayment.log';
    const MAX_LOG_FILES = 30;

    private $registry;
    private $logger;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;

        $this->initRegistry();
        $this->initLogger();
    }

    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, $context);
    }

    public function getRecentLog()
    {
        return $this->logFileToArray($this->getRecentLogPath());
    }

    public function refreshLog()
    {
        $result = $this->logFileToArray($this->getRequestedFilePath());

        $this->registry->get('response')->addHeader('Content-Type: application/json');
        $this->registry->get('response')->setOutput(json_encode($result));
    }

    public function download()
    {
        $file = $this->getRequestedFilePath();

        if (file_exists($file) && filesize($file) > 0) {
            $this->registry->get('response')->addheader('Pragma: public');
            $this->registry->get('response')->addheader('Expires: 0');
            $this->registry->get('response')->addheader('Content-Description: File Transfer');
            $this->registry->get('response')->addheader('Content-Type: application/octet-stream');
            $this->registry->get('response')
                ->addheader(
                    'Content-Disposition: attachment; filename="' .
                    $this->getLogFileName($file)
                );
            $this->registry->get('response')->addheader('Content-Transfer-Encoding: binary');

            $this->registry->get('response')
                ->setOutput(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
        } else {
            $this->registry->get('session')->data['message_warning'] = $this->registry->get('language')->get('log_file_download_error');

            $this->registry->get('response')
                ->redirect(
                    $this->registry->get('url')->link(
                        $this->registry->get('BluepaymentDictionary')->getExtensionPath(),
                        'user_token=' . $this->registry->get('session')->data['user_token'],
                        true
                    )
                );
        }
    }

    private function getRecentLogPath()
    {
        $files = $this->getFileList();

        if (is_array($files)) {
            return end($files);
        }

        return $files;
    }

    public function getFormattedFileList()
    {
        $result = [];

        foreach ($this->getFileList() as $file) {
            $result[$this->getLogFileName($file)] = $file;
        }

        return $result;
    }

    private function getFileList()
    {
        return glob(DIR_LOGS . '/bluepayment*.log');
    }

    private function getLogFileName($file_path)
    {
        $file_path_parts = explode('/', $file_path);

        return end($file_path_parts);
    }

    private function initLogger()
    {
        $this->logger = new MonologLogger(self::LOG_NAME);

        $formatter = new LineFormatter(LineFormatter::SIMPLE_FORMAT, LineFormatter::SIMPLE_DATE);
        $formatter->includeStacktraces(true);

        $logFilePath = DIR_LOGS . self::LOG_FILENAME;

        $handler = new RotatingFileHandler($logFilePath, self::MAX_LOG_FILES, MonologLogger::INFO);
        $handler->setFormatter($formatter);

        $this->logger->pushHandler($handler);
    }

    private function initRegistry()
    {
        $this->registry->get('load')->library('bluepayment/Dictionary/BluepaymentDictionary');

        $this->registry->get('load')->language($this->registry->get('BluepaymentDictionary')->getExtensionPath());
        $this->registry->get('load')->language('tool/log');
    }

    private function getRequestedFilePath()
    {
        return isset($this->registry->get('request')->get['selected_log_file'])
            ? $this->registry->get('request')->get['selected_log_file']
            : $this->getRecentLogPath();
    }

    private function logFileToArray($file)
    {
        $result['logs'] = [];
        if (file_exists($file) && filesize($file) > 0) {
            foreach (file($file, FILE_USE_INCLUDE_PATH, null) as $line) {
                $result['logs'][] = $line;
            }
        } else {
            $result['error_warning'] = $this->registry->get('language')->get('log_file_not_found');
        }

        return $result;
    }
}
