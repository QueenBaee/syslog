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

    public function edit(DowntimeLog $log)
    {
        return response()->json($log);
    }

    public function update(Request $request, DowntimeLog $log)
    {
        $validated = $request->validate([
            'down_at' => 'required|date',
            'up_at' => 'nullable|date|after:down_at',
            'reason' => 'required|string',
            'effect' => 'required|string',
        ]);

        $log->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Log updated successfully'
        ]);
    }

    public function destroy(DowntimeLog $log)
    {
        $log->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Log deleted successfully'
        ]);
    }
}
