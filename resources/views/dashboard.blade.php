@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none mb-4">
        <h1 class="page-title">Network Status Dashboard</h1>
    </div>

    <div class="row row-deck row-cards g-3 mb-4">
        <div class="col-6 col-sm-4 col-lg">
            <div class="card">
                <div class="card-body p-4 text-center">
                    <div class="text-uppercase text-muted small mb-2">Metro Ethernet</div>
                    <div class="display-6 fw-bold mb-3">{{ $stats['metro']['total'] }}</div>
                    <div class="d-flex justify-content-center gap-3">
                        <span class="badge badge-pill bg-green-lt">{{ $stats['metro']['online'] }} Online</span>
                        <span class="badge badge-pill bg-red-lt">{{ $stats['metro']['offline'] }} Offline</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg">
            <div class="card">
                <div class="card-body p-4 text-center">
                    <div class="text-uppercase text-muted small mb-2">Genset</div>
                    <div class="display-6 fw-bold mb-3">{{ $stats['genset']['total'] }}</div>
                    <div class="d-flex justify-content-center gap-3">
                        <span class="badge badge-pill bg-green-lt">{{ $stats['genset']['online'] }} Online</span>
                        <span class="badge badge-pill bg-red-lt">{{ $stats['genset']['offline'] }} Offline</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg">
            <div class="card">
                <div class="card-body p-4 text-center">
                    <div class="text-uppercase text-muted small mb-2">NAP</div>
                    <div class="display-6 fw-bold mb-3">{{ $stats['nap']['total'] }}</div>
                    <div class="d-flex justify-content-center gap-3">
                        <span class="badge badge-pill bg-green-lt">{{ $stats['nap']['online'] }} Online</span>
                        <span class="badge badge-pill bg-red-lt">{{ $stats['nap']['offline'] }} Offline</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg">
            <div class="card">
                <div class="card-body p-4 text-center">
                    <div class="text-uppercase text-muted small mb-2">Exchange</div>
                    <div class="display-6 fw-bold mb-3">{{ $stats['exchange']['total'] }}</div>
                    <div class="d-flex justify-content-center gap-3">
                        <span class="badge badge-pill bg-green-lt">{{ $stats['exchange']['online'] }} Online</span>
                        <span class="badge badge-pill bg-red-lt">{{ $stats['exchange']['offline'] }} Offline</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-lg">
            <div class="card">
                <div class="card-body p-4 text-center">
                    <div class="text-uppercase text-muted small mb-2">Active Devices</div>
                    <div class="display-6 fw-bold mb-3">{{ $stats['active_device']['total'] }}</div>
                    <div class="d-flex justify-content-center gap-3">
                        <span class="badge badge-pill bg-green-lt">{{ $stats['active_device']['online'] }} Online</span>
                        <span class="badge badge-pill bg-red-lt">{{ $stats['active_device']['offline'] }} Offline</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
