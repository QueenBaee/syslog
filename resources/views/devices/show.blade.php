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
                    <button type="button" class="btn btn-ghost-primary" onclick="openEditModal({{ $device->id }})">Edit Device</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDeleteDevice({{ $device->id }}, '{{ $device->name }}')">Delete Device</button>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-ghost-secondary">Logout</button>
                    </form>
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
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-muted small">Date & Duration</th>
                                <th class="text-uppercase text-muted small">Issue Details</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($device->downtimeLogs as $log)
                            <tr>
                                <td>
                                    <div class="small fw-bold">{{ $log->down_at->format('M d, Y H:i') }}</div>
                                    @if($log->up_at)
                                        <div class="text-muted small">to {{ $log->up_at->format('M d, H:i') }}</div>
                                        @if($log->duration_minutes)
                                            @php
                                                $hours = floor($log->duration_minutes / 60);
                                                $minutes = $log->duration_minutes % 60;
                                            @endphp
                                            <span class="badge bg-blue-lt">{{ $hours }}h {{ $minutes }}m</span>
                                        @endif
                                    @else
                                        <span class="badge bg-red-lt">Still Down</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold mb-1">{{ $log->reason }}</div>
                                    <div class="text-muted small">{{ $log->effect }}</div>
                                </td>
                                <td>
                                    <div class="btn-list">
                                        <button type="button" class="btn btn-sm btn-ghost-primary" onclick="editLog({{ $log->id }})">
                                            Edit
                                        </button>
                                        @if(!$log->up_at)
                                            <button type="button" class="btn btn-sm btn-success" onclick="resolveLog({{ $log->id }})">
                                                Resolve
                                            </button>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteLog({{ $log->id }})">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-5">
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

<!-- Delete Confirmation Modal -->
<div class="modal modal-blur fade" id="deleteDeviceModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">Delete Device</div>
                <div class="text-muted">Are you sure you want to delete <strong id="deleteDeviceName"></strong>? This will also delete all downtime logs. This action cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteDeviceBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Log Modal -->
<div class="modal modal-blur fade" id="deleteLogModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">Delete Log</div>
                <div class="text-muted">Are you sure you want to delete this downtime log? This action cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteLogBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Device Modal -->
<div class="modal modal-blur fade" id="editDeviceModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editDeviceForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Device</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Category</label>
                            <select name="category" id="editCategorySelect" class="form-select" required>
                                <option value="metro">Metro</option>
                                <option value="genset">Genset</option>
                                <option value="nap">NAP</option>
                                <option value="exchange">Exchange</option>
                                <option value="active_device">Active Device</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Device Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Location</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>
                        <div id="editIpContainer" class="col-md-6 d-none">
                            <label class="form-label">IP Address</label>
                            <input type="text" name="ip_address" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Current Status</label>
                            <select name="current_status" class="form-select">
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Device</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Log Modal -->
<div class="modal modal-blur fade" id="editLogModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editLogForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Downtime Log</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Down At</label>
                            <input type="datetime-local" name="down_at" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Up At</label>
                            <input type="datetime-local" name="up_at" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Reason</label>
                            <textarea name="reason" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Effect/Impact</label>
                            <textarea name="effect" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Log</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let deleteDeviceId = null;
let deleteLogId = null;
let editLogId = null;
const deleteDeviceModal = new bootstrap.Modal(document.getElementById('deleteDeviceModal'));
const deleteLogModal = new bootstrap.Modal(document.getElementById('deleteLogModal'));
const editDeviceModal = new bootstrap.Modal(document.getElementById('editDeviceModal'));
const editLogModal = new bootstrap.Modal(document.getElementById('editLogModal'));
const editForm = document.getElementById('editDeviceForm');
const editLogForm = document.getElementById('editLogForm');
const editCategorySelect = document.getElementById('editCategorySelect');
const editIpContainer = document.getElementById('editIpContainer');

function editLog(logId) {
    editLogId = logId;
    fetch(`/logs/${logId}/edit`)
        .then(res => res.json())
        .then(log => {
            editLogForm.querySelector('[name="down_at"]').value = log.down_at.slice(0, 16);
            editLogForm.querySelector('[name="up_at"]').value = log.up_at ? log.up_at.slice(0, 16) : '';
            editLogForm.querySelector('[name="reason"]').value = log.reason;
            editLogForm.querySelector('[name="effect"]').value = log.effect;
            editLogModal.show();
        })
        .catch(error => {
            Swal.fire('Error', 'Failed to load log data', 'error');
        });
}

editLogForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(editLogForm);
    const data = {};
    formData.forEach((value, key) => data[key] = value);
    
    fetch(`/logs/${editLogId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        editLogModal.hide();
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Log updated successfully',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.reload();
        });
    })
    .catch(error => {
        Swal.fire('Error', 'Failed to update log', 'error');
    });
});

function openEditModal(deviceId) {
    fetch(`/devices/${deviceId}/edit`)
        .then(res => res.json())
        .then(device => {
            editForm.querySelector('[name="category"]').value = device.category;
            editForm.querySelector('[name="name"]').value = device.name;
            editForm.querySelector('[name="location"]').value = device.location;
            editForm.querySelector('[name="ip_address"]').value = device.ip_address || '';
            editForm.querySelector('[name="current_status"]').value = device.current_status;
            editForm.querySelector('[name="description"]').value = device.description || '';
            toggleEditIpField();
            editDeviceModal.show();
        });
}

function toggleEditIpField() {
    if (editCategorySelect.value === 'active_device') {
        editIpContainer.classList.remove('d-none');
    } else {
        editIpContainer.classList.add('d-none');
    }
}

editCategorySelect.addEventListener('change', toggleEditIpField);

editForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(editForm);
    const data = {};
    formData.forEach((value, key) => data[key] = value);
    
    fetch(`/devices/{{ $device->id }}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        editDeviceModal.hide();
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.reload();
        });
    })
    .catch(error => {
        Swal.fire('Error', 'Failed to update device', 'error');
    });
});

function confirmDeleteDevice(deviceId, deviceName) {
    deleteDeviceId = deviceId;
    document.getElementById('deleteDeviceName').textContent = deviceName;
    deleteDeviceModal.show();
}

function deleteLog(logId) {
    deleteLogId = logId;
    deleteLogModal.show();
}

document.getElementById('confirmDeleteDeviceBtn').addEventListener('click', function() {
    fetch(`/devices/${deleteDeviceId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        deleteDeviceModal.hide();
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '/devices';
        });
    })
    .catch(error => {
        deleteDeviceModal.hide();
        Swal.fire('Error', 'Failed to delete device', 'error');
    });
});

document.getElementById('confirmDeleteLogBtn').addEventListener('click', function() {
    fetch(`/logs/${deleteLogId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        deleteLogModal.hide();
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Log deleted successfully',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.reload();
        });
    })
    .catch(error => {
        deleteLogModal.hide();
        Swal.fire('Error', 'Failed to delete log', 'error');
    });
});
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
