<?php

namespace Danila718\SpaceWebTask\Traits;

/**
 * Trait for print messages to console
 */
trait LogTrait
{
    /**
     * Print success message
     *
     * @param $message
     * @return void
     */
    private function successMsg($message): void
    {
        $this->stdout("\033[32m[SUCCESS]\033[0m: " . str_replace("\n", PHP_EOL, $message));
    }

    /**
     * Print success message
     *
     * @param string $message
     * @return void
     */
    private function errorMsg(string $message): void
    {
        $this->stderr("\033[31m[ERROR]\033[0m: " . str_replace("\n", PHP_EOL, $message));
    }

    /**
     * Write message to stdout
     *
     * @param string $message
     * @return void
     */
    private function stdout(string $message): void
    {
        $stdout = fopen('php://stdout', 'w');
        fwrite($stdout, $message . PHP_EOL);
        fclose($stdout);
    }

    /**
     * Write message to stderr
     *
     * @param string $message
     * @return void
     */
    private function stderr(string $message): void
    {
        $stdout = fopen('php://stderr', 'w');
        fwrite($stdout, $message . PHP_EOL);
        fclose($stdout);
    }
}
