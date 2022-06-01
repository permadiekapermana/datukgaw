<!-- Menghubungkan dengan view template cms -->
@extends('layouts/cms')

{{-- Content --}}
@section('content')

    <!-- Breadcrumb -->
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <!-- Content -->
    <div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Chart Belanja Pegawai</h6>
                </div>
                <canvas id="belanjaPegawaiChart"></canvas>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" style="width: 100%;">Belanja Pegawai</button>
            </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-0">Chart Belanja Barang</h6>                
                </div>
                <canvas id="belanjaBarangChart"></canvas>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" style="width: 100%;">Belanja Barang</button>
            </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                <h6 class="card-title mb-1">Chart Belanja Modal</h6>
                </div>
                <canvas id="belanjaModalChart"></canvas>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" style="width: 100%;">Belanja Modal</button>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div> <!-- row -->

@endsection