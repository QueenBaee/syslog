@extends('layouts.app')

@section('title', 'Devices')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Device Management</h2>
                <div class="text-muted mt-1">Manage your network infrastructure devices</div>
            </div>
            <div class="col-auto ms-auto">
                <button type="button" class="btn btn-primary" onclick="openModal('create')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Add Device
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !request('category') ? 'active' : '' }}" href="{{ route('devices.index') }}">
                        All Devices
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('category') == 'metro' ? 'active' : '' }}" href="{{ route('devices.index', ['category' => 'metro']) }}">
                        Metro
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('category') == 'genset' ? 'active' : '' }}" href="{{ route('devices.index', ['category' => 'genset']) }}">
                        Genset
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('category') == 'nap' ? 'active' : '' }}" href="{{ route('devices.index', ['category' => 'nap']) }}">
                        NAP
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('category') == 'exchange' ? 'active' : '' }}" href="{{ route('devices.index', ['category' => 'exchange']) }}">
                        Exchange
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('category') == 'active_device' ? 'active' : '' }}" href="{{ route('devices.index', ['category' => 'active_device']) }}">
                        Active Devices
                    </a>
                </li>
            </ul>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter table-nowrap card-table" id="devicesTable">
                <thead>
                    <tr>
                        <th class="text-uppercase text-muted small">Device Name</th>
                        <th class="text-uppercase text-muted small">Category</th>
                        <th class="text-uppercase text-muted small">IP Address</th>
                        <th class="text-uppercase text-muted small">Location</th>
                        <th class="text-uppercase text-muted small">Status</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devices as $device)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $device->name }}</div>
                        </td>
                        <td>
                            <span class="badge bg-blue-lt">{{ ucfirst(str_replace('_', ' ', $device->category)) }}</span>
                        </td>
                        <td>
                            <span class="text-muted">{{ $device->ip_address ?? '—' }}</span>
                        </td>
                        <td>
                            <div class="text-muted small">{{ $device->location }}</div>
                        </td>
                        <td>
                            @if($device->current_status == 'online')
                                <span class="badge badge-pill bg-green-lt">Online</span>
                            @else
                                <span class="badge badge-pill bg-red-lt">Offline</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-list">
                                <button type="button" class="btn btn-sm btn-ghost-primary" onclick="openModal('edit', {{ $device->id }})">Edit</button>
                                <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-primary">View</a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $device->id }}, '{{ $device->name }}')">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">No devices found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($devices->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $devices->firstItem() }} to {{ $devices->lastItem() }} of {{ $devices->total() }} results
                </div>
                <nav>
                    {{ $devices->onEachSide(2)->links('custom-pagination') }}
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Device Modal -->
<div class="modal modal-blur fade" id="deviceModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="deviceForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Create Device</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Category</label>
                            <select name="category" id="categorySelect" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="metro">Metro</option>
                                <option value="genset">Genset</option>
                                <option value="nap">NAP</option>
                                <option value="exchange">Exchange</option>
                                <option value="active_device">Active Device</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Device Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Router-01" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="e.g., Building A, Floor 2" required>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div id="ip-container" class="col-md-6 d-none">
                            <label class="form-label">IP Address <span class="text-muted">(Optional)</span></label>
                            <input type="text" id="ipInput" name="ip_address" class="form-control" placeholder="e.g., 192.168.1.1">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Current Status</label>
                            <select name="current_status" class="form-select">
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Additional notes or details about this device"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Create Device</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal modal-blur fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">Are you sure?</div>
                <div class="text-muted">Do you really want to delete <strong id="deviceName"></strong>? This action cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let modalMode = 'create';
let currentDeviceId = null;
let deleteDeviceId = null;
const modal = new bootstrap.Modal(document.getElementById('deviceModal'));
const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
const form = document.getElementById('deviceForm');
const categorySelect = document.getElementById('categorySelect');
const ipContainer = document.getElementById('ip-container');
const ipInput = document.getElementById('ipInput');

function confirmDelete(deviceId, deviceName) {
    deleteDeviceId = deviceId;
    document.getElementById('deviceName').textContent = deviceName;
    deleteModal.show();
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    fetch(`/devices/${deleteDeviceId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        deleteModal.hide();
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: data.message,
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.reload();
        });
    })
    .catch(error => {
        deleteModal.hide();
        Swal.fire('Error', 'Failed to delete device', 'error');
    });
});

function openModal(mode, deviceId = null) {
    modalMode = mode;
    currentDeviceId = deviceId;
    
    // Reset form
    form.reset();
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    ipContainer.classList.add('d-none');
    ipInput.value = '';
    
    // Update UI
    document.getElementById('modalTitle').textContent = mode === 'create' ? 'Create Device' : 'Edit Device';
    document.getElementById('submitBtn').textContent = mode === 'create' ? 'Create Device' : 'Update Device';
    
    // Fetch data if edit mode
    if (mode === 'edit') {
        fetch(`/devices/${deviceId}/edit`)
            .then(res => res.json())
            .then(device => {
                form.querySelector('[name="category"]').value = device.category;
                form.querySelector('[name="name"]').value = device.name;
                form.querySelector('[name="location"]').value = device.location;
                form.querySelector('[name="ip_address"]').value = device.ip_address || '';
                form.querySelector('[name="current_status"]').value = device.current_status;
                form.querySelector('[name="description"]').value = device.description || '';
                toggleIpField();
            });
    }
    
    modal.show();
}

function toggleIpField() {
    if (categorySelect.value === 'active_device') {
        ipContainer.classList.remove('d-none');
    } else {
        ipContainer.classList.add('d-none');
        ipInput.value = '';
    }
}

categorySelect.addEventListener('change', toggleIpField);

form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(form);
    const url = modalMode === 'create' ? '/devices' : `/devices/${currentDeviceId}`;
    const method = modalMode === 'create' ? 'POST' : 'PUT';
    
    // Convert FormData to JSON for PUT request
    const data = {};
    formData.forEach((value, key) => data[key] = value);
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            if (response.status === 422) {
                return response.json().then(data => {
                    throw { validation: true, errors: data.errors };
                });
            }
            throw new Error('Server error');
        }
        return response.json();
    })
    .then(data => {
        modal.hide();
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
        if (error.validation) {
            Object.keys(error.errors).forEach(field => {
                const input = form.querySelector(`[name="${field}"]`);
                const feedback = input.nextElementSibling;
                input.classList.add('is-invalid');
                feedback.textContent = error.errors[field][0];
            });
        } else {
            Swal.fire('Error', error.message, 'error');
        }
    });
});
</script>
@endpush
