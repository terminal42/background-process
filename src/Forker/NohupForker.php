<?php

namespace Terminal42\BackgroundProcess\Forker;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class NohupForker extends AbstractForker
{
    /**
     * {@inheritdoc}
     */
    public function run($configFile)
    {
        $commandline = sprintf(
            'nohup %s %s >/dev/null </dev/null 2>&1 &',
            $this->executable,
            escapeshellarg($configFile)
        );

        return $this->startCommand($commandline);
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported()
    {
        try {
            (new Process('nohup ls'))->mustRun();
        } catch (ProcessFailedException $e) {
            return false;
        }

        return true;
    }
}
