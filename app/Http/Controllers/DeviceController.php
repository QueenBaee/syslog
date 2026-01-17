<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\Device;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function dashboard()
    {
        $rawStats = Device::selectRaw('category, current_status, COUNT(*) as count')
            ->groupBy('category', 'current_status')
            ->get()
            ->groupBy('category');

        $categories = ['metro', 'genset', 'nap', 'exchange', 'active_device'];
        $stats = collect($categories)->mapWithKeys(fn($cat) => [
            $cat => [
                'total' => $rawStats->get($cat)?->sum('count') ?? 0,
                'online' => $rawStats->get($cat)?->firstWhere('current_status', 'online')?->count ?? 0,
                'offline' => $rawStats->get($cat)?->firstWhere('current_status', 'offline')?->count ?? 0,
            ]
        ])->toArray();

        return view('dashboard', compact('stats'));
    }

    public function index(Request $request)
    {
        $query = Device::query();
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        $devices = $query->latest()->paginate(15)->withQueryString();
        
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(StoreDeviceRequest $request)
    {
        $data = $request->validated();
        
        if ($data['category'] !== 'active_device') {
            $data['ip_address'] = null;
        }
        
        $device = Device::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Device created successfully',
            'device' => $device
        ]);
    }

    public function show(Device $device)
    {
        $device->load('downtimeLogs');
        return view('devices.show', compact('device'));
    }

    public function edit(Device $device)
    {
        return response()->json($device);
    }

    public function update(UpdateDeviceRequest $request, Device $device)
    {
        $data = $request->validated();
        
        if ($data['category'] !== 'active_device') {
            $data['ip_address'] = null;
        }
        
        $device->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Device updated successfully',
            'device' => $device
        ]);
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Device deleted successfully.');
    }

    public function printLogs(Request $request, Device $device)
    {
        if ($request->filter === 'current_month') {
            $device->load(['downtimeLogs' => function($query) {
                $query->whereMonth('down_at', now()->month)
                      ->whereYear('down_at', now()->year)
                      ->latest('down_at');
            }]);
            $periodText = now()->format('F Y');
        } else {
            $device->load('downtimeLogs');
            $periodText = 'All Time History';
        }
        
        $pdf = Pdf::loadView('devices.pdf', compact('device', 'periodText'));
        return $pdf->download('device_log_' . $device->id . '_' . now()->format('Y-m-d') . '.pdf');
    }
}
