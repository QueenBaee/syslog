<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Maintenance Log Report - {{ $device->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #000;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .device-info {
            background: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .device-info table {
            width: 100%;
        }
        .device-info td {
            padding: 5px 0;
        }
        .device-info td:first-child {
            font-weight: bold;
            width: 150px;
        }
        .logs-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .logs-table th {
            background: #333;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        .logs-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        .logs-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-online {
            background: #d4edda;
            color: #155724;
        }
        .status-offline {
            background: #f8d7da;
            color: #721c24;
        }
        .status-down {
            background: #fff3cd;
            color: #856404;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .no-logs {
            text-align: center;
            padding: 30px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Maintenance Log Report</h1>
        <p style="font-size: 14px; font-weight: bold; color: #333; margin: 10px 0;">Period: {{ $periodText }}</p>
        <p>Generated on {{ now()->format('F d, Y - H:i') }}</p>
    </div>

    <div class="device-info">
        <table>
            <tr>
                <td>Device Name:</td>
                <td><strong>{{ $device->name }}</strong></td>
            </tr>
            <tr>
                <td>Category:</td>
                <td>{{ ucfirst(str_replace('_', ' ', $device->category)) }}</td>
            </tr>
            <tr>
                <td>Location:</td>
                <td>{{ $device->location }}</td>
            </tr>
            @if($device->ip_address)
            <tr>
                <td>IP Address:</td>
                <td>{{ $device->ip_address }}</td>
            </tr>
            @endif
            <tr>
                <td>Current Status:</td>
                <td>
                    <span class="status-badge {{ $device->current_status == 'online' ? 'status-online' : 'status-offline' }}">
                        {{ strtoupper($device->current_status) }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <h2 style="margin-top: 30px; margin-bottom: 10px; font-size: 16px;">Downtime History</h2>

    @if($device->downtimeLogs->count() > 0)
    <table class="logs-table">
        <thead>
            <tr>
                <th>Down At</th>
                <th>Up At</th>
                <th>Duration</th>
                <th>Reason</th>
                <th>Impact/Effect</th>
            </tr>
        </thead>
        <tbody>
            @foreach($device->downtimeLogs as $log)
            <tr>
                <td>{{ $log->down_at->format('M d, Y H:i') }}</td>
                <td>
                    @if($log->up_at)
                        {{ $log->up_at->format('M d, Y H:i') }}
                    @else
                        <span class="status-badge status-down">Still Down</span>
                    @endif
                </td>
                <td>
                    @if($log->duration_minutes && $log->up_at)
                        {{ floor($log->duration_minutes / 60) }}h {{ $log->duration_minutes % 60 }}m
                    @else
                        —
                    @endif
                </td>
                <td>{{ $log->reason }}</td>
                <td>{{ $log->effect }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-logs">
        No maintenance or downtime records found for this device.
    </div>
    @endif

    <div class="footer">
        <p>This report was automatically generated by the ISP Network Monitoring System</p>
        <p>Total Records: {{ $device->downtimeLogs->count() }}</p>
    </div>
</body>
</html>
