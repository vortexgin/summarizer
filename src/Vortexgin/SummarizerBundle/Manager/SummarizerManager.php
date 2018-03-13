<?php

namespace Vortexgin\SummarizerBundle\Manager;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SummarizerManager
{

    private $_summarizer = 'summarizer';

    private $_summarizerUrl = 'summarizer_url';

    private $_basePath;

    public function __construct()
    {
        $basePath = realpath(dirname(__FILE__)).'/../../../../';
        $this->_basePath = $basePath.'bin/summarizer/';
    }

    public function analyze($sentence)
    {
        try {
            $command = "cd {$this->_basePath} && python {$this->_summarizer} \"{$sentence}\"";
            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output = $process->getOutput();

            return json_decode($output, true);
        } catch(ProcessFailedException $e) {
            return false;
        } catch(\Exception $e) {
            return false;
        }
    }

    public function analyzeUrl($url)
    {
        try {
            $command = "cd {$this->_basePath} && python {$this->_summarizerUrl} \"{$url}\"";
            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output = $process->getOutput();

            return json_decode($output, true);
        } catch(ProcessFailedException $e) {
            return false;
        } catch(\Exception $e) {
            return false;
        }
    }
}
