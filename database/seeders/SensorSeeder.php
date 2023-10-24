<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\ManageStatusModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $startDate = Carbon::create(2023, 1, 1); // Tanggal mulai
        $endDate = Carbon::create(2023, 1, 3); // Tanggal akhir

        $totalMinutes = $startDate->diffInMinutes($endDate); // Jumlah menit dalam rentang tanggal
        $totalDataPerMinute = 1; // Jumlah data yang ingin disimpan setiap menit

        $data = [];

        for ($minute = 0; $minute < $totalMinutes; $minute++) {
            $createdAtMinute = $startDate->copy()->addMinutes($minute);
            $updatedAtMinute = $startDate->copy()->addMinutes($minute + 1);

            for ($i = 0; $i < $totalDataPerMinute; $i++) {
                $power = $faker->randomFloat(2, 240, 270);
                // $kwh = $power / 500;
                $kwh = $power * 500 / 3600;


                $createdAt = $createdAtMinute->copy()->addSeconds($i);
                $updatedAt = $createdAtMinute->copy()->addSeconds($i + 1);

                if ($createdAt->greaterThan($updatedAtMinute)) {
                    break; // Menghentikan perulangan jika melewati batas waktu dalam satu menit
                }

                if ($createdAt->greaterThan($endDate)) {
                    break 2; // Menghentikan perulangan jika melewati batas tanggal akhir
                }

                $data[] = [
                    'mac_address' => '00:B0:D0:63:C2:26',
                    'voltage' => $faker->randomFloat(2, 27, 29),
                    'current' => $faker->randomFloat(2, 0.12, 0.16),
                    'power' => $power,
                    'energy' => $faker->randomFloat(2, 1.1, 1.3),
                    'frequency' => $faker->randomFloat(2, 48, 50),
                    'powerfactor' => $faker->randomFloat(2, 0.75, 0.9),
                    'kwh' => $kwh,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt
                ];
            }

            if (count($data) >= 500) {
                ManageStatusModel::insert($data);
                $data = [];
            }
        }

        if (count($data) > 0) {
            ManageStatusModel::insert($data);
        }
    }
}
