<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DowntimeLog;
use Illuminate\Http\Request;

class DowntimeLogController extends Controller
{
    public function store(Request $request, Device $device)
    {
        $validated = $request->validate([
            'down_at' => 'required|date',
            'reason' => 'required|string',
            'effect' => 'required|string',
        ]);

        $device->downtimeLogs()->create($validated);

        return redirect()->route('devices.show', $device)->with('success', 'Downtime reported successfully.');
    }

    public function update(Request $request, DowntimeLog $log)
    {
        $validated = $request->validate([
            'up_at' => 'required|date|after:' . $log->down_at,
            'reason' => 'sometimes|string',
            'effect' => 'sometimes|string',
        ]);

        $log->update($validated);

        return redirect()->route('devices.show', $log->device_id)->with('success', 'Downtime resolved successfully.');
    }
}
