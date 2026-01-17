@extends('layouts.app')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none mb-4">
        <h1 class="page-title">Create Device</h1>
        <div class="text-muted mt-1">Add a new device to your network infrastructure</div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('devices.store') }}" method="POST">
                @csrf
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">Category</label>
                        <select name="category" id="categorySelect" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            <option value="metro" {{ old('category') === 'metro' ? 'selected' : '' }}>Metro</option>
                            <option value="genset" {{ old('category') === 'genset' ? 'selected' : '' }}>Genset</option>
                            <option value="nap" {{ old('category') === 'nap' ? 'selected' : '' }}>NAP</option>
                            <option value="exchange" {{ old('category') === 'exchange' ? 'selected' : '' }}>Exchange</option>
                            <option value="active_device" {{ old('category') === 'active_device' ? 'selected' : '' }}>Active Device</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">Device Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="e.g., Router-01" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">Location</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                               value="{{ old('location') }}" placeholder="e.g., Building A, Floor 2" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="ip-container" class="col-md-6 d-none">
                        <label class="form-label">IP Address <span class="text-muted">(Optional)</span></label>
                        <input type="text" id="ipInput" name="ip_address" class="form-control @error('ip_address') is-invalid @enderror" 
                               value="{{ old('ip_address') }}" placeholder="e.g., 192.168.1.1">
                        @error('ip_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Current Status</label>
                        <select name="current_status" class="form-select @error('current_status') is-invalid @enderror">
                            <option value="online" {{ old('current_status') === 'online' ? 'selected' : '' }}>Online</option>
                            <option value="offline" {{ old('current_status') === 'offline' ? 'selected' : '' }}>Offline</option>
                        </select>
                        @error('current_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="Additional notes or details about this device">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Create Device</button>
                    <a href="{{ route('devices.index') }}" class="btn btn-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleIpField() {
    const categorySelect = document.getElementById('categorySelect');
    const ipContainer = document.getElementById('ip-container');
    const ipInput = document.getElementById('ipInput');
    
    if (categorySelect.value === 'active_device') {
        ipContainer.classList.remove('d-none');
    } else {
        ipContainer.classList.add('d-none');
        ipInput.value = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleIpField();
    document.getElementById('categorySelect').addEventListener('change', toggleIpField);
});
</script>
@endsection
