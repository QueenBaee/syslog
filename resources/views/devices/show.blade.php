@extends('layouts.app')

@section('title', 'Device Details')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-pretitle text-muted">Device Details</div>
                <h2 class="page-title">{{ $device->name }}</h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    @if($device->is_down)
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#resolveModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            Mark as Resolved
                        </button>
                    @endif
                    <a href="{{ route('devices.print-logs', $device) }}" class="btn btn-secondary" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg>
                        Print PDF
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('devices.print-logs', $device) }}" target="_blank">
                                All Time History
                            </a>
                            <a class="dropdown-item" href="{{ route('devices.print-logs', ['device' => $device, 'filter' => 'current_month']) }}" target="_blank">
                                This Month Only
                            </a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#downtimeModal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
                        Report Downtime
                    </button>
                    <a href="{{ route('devices.edit', $device) }}" class="btn btn-ghost-primary">Edit Device</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <span class="avatar avatar-xl rounded" style="background-color: var(--tblr-primary-lt);">
                            @if($device->category === 'active_device')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="4" width="18" height="8" rx="3" /><rect x="3" y="12" width="18" height="8" rx="3" /><line x1="7" y1="8" x2="7" y2="8.01" /><line x1="7" y1="16" x2="7" y2="16.01" /></svg>
                            @elseif($device->category === 'genset')
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="13 3 13 10 19 10 11 21 11 14 5 14 13 3" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="3.6" y1="9" x2="20.4" y2="9" /><line x1="3.6" y1="15" x2="20.4" y2="15" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a17 17 0 0 1 0 18" /></svg>
                            @endif
                        </span>
                    </div>
                    <h3 class="mb-1">{{ $device->name }}</h3>
                    <div class="text-muted mb-3">{{ ucfirst(str_replace('_', ' ', $device->category)) }}</div>
                    <div class="mb-4">
                        @if($device->current_status == 'online')
                            <span class="badge badge-pill bg-green-lt fs-3 px-3 py-2">● Online</span>
                        @else
                            <span class="badge badge-pill bg-red-lt fs-3 px-3 py-2">● Offline</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="text-uppercase text-muted small mb-1">Location</div>
                            <div class="fw-bold">{{ $device->location }}</div>
                        </div>
                        @if($device->ip_address)
                        <div class="col-12">
                            <div class="text-uppercase text-muted small mb-1">IP Address</div>
                            <div class="font-monospace">{{ $device->ip_address }}</div>
                        </div>
                        @endif
                        @if($device->description)
                        <div class="col-12">
                            <div class="text-uppercase text-muted small mb-1">Description</div>
                            <div class="text-muted">{{ $device->description }}</div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="text-uppercase text-muted small mb-1">Created</div>
                            <div class="text-muted small">{{ $device->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Maintenance & Downtime History</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter table-nowrap card-table">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-muted small">Down At</th>
                                <th class="text-uppercase text-muted small">Up At</th>
                                <th class="text-uppercase text-muted small">Duration</th>
                                <th class="text-uppercase text-muted small">Reason</th>
                                <th class="text-uppercase text-muted small">Impact</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($device->downtimeLogs as $log)
                            <tr>
                                <td>
                                    <div class="small">{{ $log->down_at->format('M d, Y') }}</div>
                                    <div class="text-muted small">{{ $log->down_at->format('H:i') }}</div>
                                </td>
                                <td>
                                    @if($log->up_at)
                                        <div class="small">{{ $log->up_at->format('M d, Y') }}</div>
                                        <div class="text-muted small">{{ $log->up_at->format('H:i') }}</div>
                                    @else
                                        <span class="badge badge-pill bg-red-lt">Still Down</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log->up_at && $log->duration_minutes)
                                        @php
                                            $hours = floor($log->duration_minutes / 60);
                                            $minutes = $log->duration_minutes % 60;
                                        @endphp
                                        <span class="text-muted">{{ $hours }}h {{ $minutes }}m</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $log->reason }}">{{ $log->reason }}</div>
                                </td>
                                <td>
                                    <div class="text-truncate text-muted" style="max-width: 200px;" title="{{ $log->effect }}">{{ $log->effect }}</div>
                                </td>
                                <td>
                                    @if(!$log->up_at)
                                        <button type="button" class="btn btn-sm btn-success" onclick="resolveLog({{ $log->id }})">
                                            Resolve
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-muted mb-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><rect x="9" y="3" width="6" height="4" rx="2" /><path d="M9 14l2 2l4 -4" /></svg>
                                    <div>No maintenance records found</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Downtime Modal -->
<div class="modal modal-blur fade" id="downtimeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('devices.logs.store', $device) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Report Downtime</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Down At</label>
                        <input type="datetime-local" name="down_at" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Reason</label>
                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Effect/Impact</label>
                        <textarea name="effect" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Resolve Modal -->
@if($device->is_down)
@php
    $currentDownLog = $device->downtimeLogs->first(fn($log) => is_null($log->up_at));
@endphp
@if($currentDownLog)
<div class="modal modal-blur fade" id="resolveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('logs.update', $currentDownLog) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Resolve Downtime</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Up At</label>
                        <input type="datetime-local" name="up_at" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Mark as Resolved</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endif

@push('scripts')
<script>
function resolveLog(logId) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url('logs') }}/${logId}`;
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    
    const upAtInput = document.createElement('input');
    upAtInput.type = 'hidden';
    upAtInput.name = 'up_at';
    upAtInput.value = new Date().toISOString().slice(0, 19).replace('T', ' ');
    
    form.appendChild(csrfInput);
    form.appendChild(methodInput);
    form.appendChild(upAtInput);
    
    document.body.appendChild(form);
    form.submit();
}
</script>
@endpush
@endsection
