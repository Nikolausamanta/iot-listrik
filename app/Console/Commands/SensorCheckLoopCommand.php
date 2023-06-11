<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SensorCheckLoopCommand extends Command
{
    protected $signature = 'sensor:check:loop';
    protected $description = 'Continuously check sensor data';

    public function handle()
    {
        while (true) {
            $this->call('sensor:check');
            sleep(5);
        }
    }
}
