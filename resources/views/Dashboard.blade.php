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
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body filter">
                <h6 class="card-title">Filter</h6>
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Tahun</label>
                                    <select class="form-select" id="filterTahun" aria-label="Default select example" disabled>
                                    </select>
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                    </form>
                    <div class="row">
                        <div class="col-sm-12" style="text-align: right;">
                            <button type="button" class="btn btn-light submit" onclick="clearFilter()" disabled><i data-feather="x" class="feather-16"></i> Clear</button>
                            <button type="button" class="btn btn-dark submit" onclick="search(1)" disabled><i data-feather="search" class="feather-16"></i> Search</button>
                        </div><!-- Col -->
                    </div><!-- Row -->
                </div>
            </div>
        </div>
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
    </div> <!-- row -->

@endsection