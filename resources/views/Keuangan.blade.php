<!-- Menghubungkan dengan view template cms -->
@extends('layouts/cms')

{{-- Content --}}
@section('content')

    <!-- Breadcrumb -->
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            {{-- <li class="breadcrumb-item"><a href="#">Keuangan</a></li> --}}
            <li class="breadcrumb-item active" aria-current="page">Keuangan</li>
        </ol>
    </nav>

    <!-- Content -->
    <div class="row">
    {{-- Filter Search --}}
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body filter">
                <h6 class="card-title">Filter Chart</h6>
                <form>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Tahun</label>
                                <select class="form-select" id="filterTahun" aria-label="Default select example" disabled>
                                    <option value="" selected>Semua Tahun</option>
                                    <option value="Daftar Gaji">Daftar Gaji</option>
                                    <option value="Uang Makan">Uang Makan</option>
                                    <option value="Tunjangan Kinerja">Tunjangan Kinerja</option>
                                </select>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                </form>
                <h6 class="card-title">Filter Data</h6>
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipe Dokumen</label>
                                    <select class="form-select" id="filterTipeDokumen" aria-label="Default select example" disabled>
                                        <option value="" selected>Semua Tipe Dokumen</option>
                                        <option value="Belanja Pegawai">Belanja Pegawai</option>
                                        <option value="Belanja Barang">Belanja Barang</option>
                                        <option value="Belanja Modal">Belanja Modal</option>
                                    </select>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Jenis Dokumen</label>
                                    <select class="form-select" id="filterJenisDokumen" aria-label="Default select example" disabled>
                                        <option value="" selected>Semua Jenis Dokumen</option>
                                        <option value="Daftar Gaji">Daftar Gaji</option>
                                        <option value="Uang Makan">Uang Makan</option>
                                        <option value="Tunjangan Kinerja">Tunjangan Kinerja</option>
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
    </div>
    {{-- Chart --}}
    <div class="grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row flex-grow">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Chart Belanja Pegawai</h6>
                    </div>
                    <canvas id="belanjaPegawaiChart"></canvas>
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
                </div>
            </div>
            </div>
        </div>
    </div>
    </div>
    {{-- End Chart --}}
    {{-- Table --}}
    <div class="card">
        <div class="card-body">
            {{-- Button Group --}}
            <div class="row">
                <div class="col-sm-12" style="text-align: right;">
                    <button type="button" class="btn btn-light mb-3" onClick="add()" disabled><i data-feather="plus" class="feather-16"></i> Add</button>
                </div><!-- Col -->
            </div>
            <!-- End Button Group -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="25%">Jenis Dokumen</th>
                                    <th width="10%">Tipe Dokumen</th>
                                    <th width="20%">Nama Dokumen</th>
                                    <th width="7%">Nomor Dokumen</th>
                                    <th width="8%">Last Update By</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="loading" class="table-placeholder">
                                    <td colspan="8"><p><i class="fa fa-spinner fa-pulse"></i> Getting data...</p></td>
                                </tr>
                                <tr id="nodata" class="table-placeholder hide">
                                    <td colspan="8"><p><i class="fa fa-search"></i> No data found</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- Col -->
                <div id="tableInfo" class="col-sm-6" style="margin-top: 10px;">

                </div><!-- Col -->
                    <div class="col-sm-3" style="margin-top: 10px;">
                        &nbsp;
                    </div><!-- Col -->
                    <div id="pagination" class="col-sm-3" style="margin-top: 10px;">
                    </div><!-- Col -->
                </div><!-- Row -->
            </div>
        </div>
    {{-- End Table --}}

    {{-- Modal insert data --}}
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modal-system" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">!will be set on the function!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden= "true">&times;</span>
            </button>
        </div>
        <form class="forms-sample" action="#">
        <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12" id="msgBox">
                    </div>
                </div>
                <input type="hidden" class="form-control" id="id" name="id">
                <div class="form-group row">
                    <label for="date" class="col-sm-3 col-form-label">Tanggal</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="date" name="date" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jenis_dokumen" class="col-sm-3 col-form-label">Jenis Dokumen</label>
                    <div class="col-sm-9">
                        <select class="form-select" name="jenis_dokumen" id="jenis_dokumen" aria-label="Default select example" disabled>
                            <option value="" selected>-- Pilih Jenis Dokumen --</option>
                            <option value="Daftar Gaji">Daftar Gaji</option>
                            <option value="Uang Makan">Uang Makan</option>
                            <option value="Tunjangan Kinerja">Tunjangan Kinerja</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tipe_dokumen" class="col-sm-3 col-form-label">Tipe Dokumen</label>
                    <div class="col-sm-9">
                        <select class="form-select" name="tipe_dokumen" id="tipe_dokumen" aria-label="Default select example" disabled>
                            <option value="" selected>-- Pilih Tipe Dokumen --</option>
                            <option value="Belanja Pegawai">Belanja Pegawai</option>
                            <option value="Belanja Barang">Belanja Barang</option>
                            <option value="Belanja Modal">Belanja Modal</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_dokumen" class="col-sm-3 col-form-label">Nama Dokumen</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_dokumen" name="nama_dokumen" placeholder="Nama Dokumen">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nomor_dokumen" class="col-sm-3 col-form-label">Nomor Dokumen</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nomor_dokumen" name="nomor_dokumen" placeholder="Nomor Dokumen">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="deskripsi_dokumen" class="col-sm-3 col-form-label">Deskripsi Dokumen</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="deskripsi_dokumen" name="deskripsi_dokumen" placeholder="Deskripsi Dokumen" rows='7'></textarea>
                    </div>
                </div>
                <div id="upload_file"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-cancel btn-light" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-input btn-dark" onClick="save()">Save</button>
        </div>
        </div>
        </form>
    </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modal-system" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPreviewLabel">!will be set on the function!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden= "true">&times;</span>
                    </button>
                </div>
                <form class="forms-sample" action="#">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <iframe id="previewFrame" style="width: 100%; height: 65vh;"></iframe>
                            </div>
                        </div>          
                    </div>
                    <div id="footerPreview" class="modal-footer">
                        <!-- will be set on js -->
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('jquery')
<!-- JQUERY -->
<script src="{{ asset('jquery/keuangan.js') }}"></script>
@endsection