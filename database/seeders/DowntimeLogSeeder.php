<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\DowntimeLog;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DowntimeLogSeeder extends Seeder
{
    public function run(): void
    {
        // Create Metro CGS MLG - PAS device first
        $device = Device::create([
            'category' => 'metro',
            'name' => 'Metro CGS MLG - PAS',
            'location' => 'Malang - Pasuruan',
            'description' => 'Metro Ethernet connection between Malang and Pasuruan',
            'current_status' => 'online'
        ]);

        // Downtime logs data
        $logs = [
            ['2025-10-06 14:19', '2025-10-06 15:15', 'Gangguan BB POP Malang–Pasuruan dari CGS', 'Service disruption'],
            ['2025-10-14 21:51', '2025-10-14 21:54', 'Gangguan dari CGS', 'Service disruption'],
            ['2025-11-14 05:02', '2025-11-14 08:40', 'Gangguan backbone dari CGS', 'Backbone disruption'],
            ['2025-11-27 23:00', '2025-11-27 23:59', 'Maintenance dari CGS', 'Scheduled maintenance'],
            ['2025-11-28 00:00', '2025-11-28 03:00', 'Maintenance lanjutan dari CGS', 'Extended maintenance'],
            ['2025-12-09 17:59', '2025-12-09 18:49', 'Gangguan backbone Malang–Purwosari dari CGS', 'Backbone disruption'],
            ['2025-12-11 00:00', '2025-12-11 06:00', 'Pemindahan server oleh Naratel', 'Server migration'],
            ['2025-12-17 22:06', '2025-12-17 22:07', 'Link flapping dari CGS', 'Link instability'],
            ['2025-12-17 23:49', '2025-12-17 23:50', 'Link flapping dari CGS', 'Link instability'],
            ['2025-12-18 12:21', '2025-12-18 12:22', 'Link flapping dari CGS', 'Link instability'],
            ['2025-12-18 13:22', '2025-12-18 13:23', 'Link flapping dari CGS', 'Link instability'],
            ['2025-12-18 20:30', '2025-12-19 02:36', 'Gangguan FO Cut dari CGS', 'Fiber optic cut'],
            ['2025-12-24 00:00', '2025-12-24 03:00', 'Replace UPS POP Malang dari CGS', 'UPS replacement'],
            ['2025-12-30 17:25', '2025-12-30 22:30', 'FO Cut Raci, Vandalism', 'Fiber cut due to vandalism'],
            ['2026-01-06 11:20', '2026-01-06 11:21', 'Link flapping dari CGS', 'Link instability'],
            ['2026-01-14 07:27', '2026-01-14 17:53', 'FO Cut dari CGS', 'Fiber optic cut'],
            ['2026-01-20 01:26', '2026-01-20 08:15', 'FO Cut dari CGS', 'Fiber optic cut'],
            ['2026-01-20 11:06', '2026-01-20 12:13', 'FO Cut dari CGS', 'Fiber optic cut'],
        ];

        foreach ($logs as $log) {
            $downAt = Carbon::parse($log[0]);
            $upAt = Carbon::parse($log[1]);
            $durationMinutes = $downAt->diffInMinutes($upAt);

            DowntimeLog::create([
                'device_id' => $device->id,
                'down_at' => $downAt,
                'up_at' => $upAt,
                'reason' => $log[2],
                'effect' => $log[3],
                'duration_minutes' => $durationMinutes
            ]);
        }
    }
}