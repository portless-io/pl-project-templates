<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand;
use Symfony\Component\Console\Input\InputOption;

class CustomServeCommand extends ServeCommand
{
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        $host = env('SERVE_HOST', '0.0.0.0');

        $port = env('SERVE_PORT', 3000);

        return [
            ['host', null, InputOption::VALUE_OPTIONAL, 'The host address to serve the application on.', $host],
            ['port', null, InputOption::VALUE_OPTIONAL, 'The port to serve the application on.', $port],
            ['tries', null, InputOption::VALUE_OPTIONAL, 'The max number of ports to attempt to serve from', 10],
            ['no-reload', null, InputOption::VALUE_NONE, 'Do not reload the development server on .env file changes'],
        ];
    }
}
