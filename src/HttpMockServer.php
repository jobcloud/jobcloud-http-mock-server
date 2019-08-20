<?php

declare(strict_types=1);

namespace Jobcloud\HttpMockServer;

use Symfony\Component\Process\Process;

final class HttpMockServer
{
    /**
     * @param int             $port
     * @param array<Response> $responses
     *
     * @return void
     */
    public function run(int $port, array $responses): void
    {
        $process = new Process([
            realpath(__DIR__.'/../bin/httpMockServer'),
            $port,
            json_encode($responses),
        ]);

        $process->start();

        $output = '';
        while ($process->isRunning()) {
            $output .= $process->getIncrementalOutput();
            if (false !== strpos($output, 'http server mock: started')) {
                break;
            }
            usleep(10000);
        }
    }
}
