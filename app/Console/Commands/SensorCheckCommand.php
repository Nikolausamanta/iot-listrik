<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ManageStatusModel;

class SensorCheckCommand extends Command
{
    protected $signature = 'sensor:check';
    protected $description = 'Check sensor data';

    public function handle()
    {
        $macAddresses = ManageStatusModel::pluck('mac_address');

        foreach ($macAddresses as $macAddress) {
            // Check if data exists for the last minute
            $lastMinuteData = ManageStatusModel::where('mac_address', $macAddress)
                ->where('created_at', '>=', now()->subMinute())
                ->count();

            if ($lastMinuteData === 0) {
                // Data not found, create a new record with values set to 0
                ManageStatusModel::create([
                    'mac_address' => $macAddress,
                    'voltage' => 0,
                    'current' => 0,
                    'power' => 0,
                    'energy' => 0,
                    'frequency' => 0,
                    'powerfactor' => 0,
                ]);
            }
        }

        $this->info('Sensor data checked successfully.');
    }
}
